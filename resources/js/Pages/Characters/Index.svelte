<script>

	import { onMount } from 'svelte';
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import Grid					from '@/Components/Core/Grid.svelte'
	import Stack				from '@/Components/Core/Stack.svelte'
	import ControlBar			from '@/Components/UI/ControlBar.svelte'
	import Empty				from '@/Components/UI/Empty.svelte'
	import Entity				from '@/Components/UI/Entity.svelte'
	import PageHeader			from '@/Components/UI/PageHeader.svelte'
	import PageHeading			from '@/Components/UI/PageHeading.svelte'
	import CharacterTable		from '@/Components/Features/Character/CharacterTable.svelte'
	import ProjectObject 		from '@/services/ProjectObject'


	/**
	 * Active project instance
	 * @type {ProjectObject}
	 */
	const activeProject	  = new ProjectObject($page.props.activeProject.data)
	const characters      = activeProject?.characters


	/**
	 * URL search parameters for state persistence
	 * @type {URLSearchParams}
	 */
	let urlParams = new URLSearchParams(typeof window !== 'undefined' ? window.location.search : '');


	/**
	 * Reactive application state parameters
	 * @typedef {Object} AppParameters
	 * @property {number} size - Grid size/layout parameter
	 * @property {string} layout - Display layout ('grid' or 'table')
	 * @property {string} selected - Slug of currently selected faction
	 */
	/**
	 * Reactive state parameters for filtering, sorting, and layout
	 * @type {AppParameters}
	 */
	let parameters = $state({
		sort:		urlParams.get('sort')	  || 'name',
		size: 		urlParams.get('size')	  || 5,
		layout: 	urlParams.get('layout')	  || 'grid',
		selected: 	urlParams.get('selected') || ''
	})

	/**
	 * Derived grid columns calculation based on size parameter
	 * @type {number}
	 */
	let gridCols = $derived(10-parameters.size)

	/**
	 * Derived filtered/sorted results
	 * @type {Array<CharacterObject>}
	 */
	let results  = $derived(characters.items)


	/**
	 * Sync with URL - Update filters from URL on component mount
	 * @returns {void}
	 */
	onMount(() => {
		urlParams = new URLSearchParams(window.location.search);
		parameters = {
			sort:		urlParams.get('sort')	  || 'name',
			size: 		urlParams.get('size') 	  || 5,
			layout: 	urlParams.get('layout')   || 'grid',
			selected: 	urlParams.get('selected') || ''
		};
	});


	/**
	 * Update URL - Sync URL params with state changes (without page reload)
	 * @returns {void}
	 */
	$effect(() => {
		const url = new URL(window.location);
		url.searchParams.set('size',		parameters.size);
		url.searchParams.set('layout',		parameters.layout);
		url.searchParams.set('selected',	parameters.selected);
		window.history.replaceState({}, '', url);
	});


	/**
	 * Generate subtitle text for character cards based on current sort criteria
	 * @param {CharacterObject} character | A CharacterObject class instance
	 * @returns {string} subtitle to display on Character Cards
	 */
	function getSubtitle(character) {
		switch (parameters.sort) {
			case 'popularity':
				return character.relationships?.items?.length + ' Relationships'
			case 'location':
				return character.location?.name || '--'
			case 'faction':
				return character.factions?.items?.[0]?.name || '--'
			case 'created_at':
				return character.meta.created.ago || '--'
			case 'updated_at':
				return character.meta.updated.ago || '--'
			default:
				if (parameters.sort?.includes('cf.')) {
					return character.customFieldValues.find(v => v.name === parameters.sort.split('.')[1])?.displayValue || '--'
				} else {
					return character.alias || '--'
				}
		}
	}

	/**
	 * Select or deselect a character in the UI
	 * @param {CharacterObject} character | A CharacterObject class instance
	 * @return {void}
	 */
	// function selectCharacter(character) {
	// 	const url = new URL(window.location);
	// 	url.searchParams.set('selected', character?.slug)
	// 	parameters.selected = parameters.selected === character.slug ? null : character.slug
	// }

</script>



<svelte:head>
    <title>Character List</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Stack class="overflow-y-auto px-20 py-12">

			<PageHeading
				title="Character List"
				subtitle="Index page"
				actions={[
					{ icon: "GearFine", theme: "neutral", href: route('characters.settings') },
					{ icon: "Plus", text: "New", theme: "accent", onclick: () => characters.openModal('create') },
				]}
			/>
			
			<ControlBar class="py-3"
				data={characters} bind:results
				bind:layout={parameters.layout} bind:sort={parameters.sort} bind:size={parameters.size}
				filterOptions={activeProject.getOptions('characters', 'filter')}
				sortOptions={activeProject.getOptions('characters', 'sort')}
				layoutOptions={activeProject.getOptions('characters', 'layout')}
				sizeOptions={{ min: 3, max: 7 }}
				resizeable={parameters.layout === 'grid'}
			/>

			{#if activeProject && characters.items.length > 0}

				{#if parameters.layout === 'grid'}

					<!-- Grid -->

					<Grid class="py-3 w-full" cols={gridCols} gap={3}>
						{#if results.length > 0}
							{#each results as character}
								<Entity
									active={parameters.selected === character.slug}
									entity={character}
									subtitle={getSubtitle(character)}
									href={character.routes.show}
								/>
							{/each}
						{:else}
							<Empty class="col-span-full" icon="Empty" text="No results found. Try changing your filters." />
						{/if}
					</Grid>

				{:else if parameters.layout === 'table'}

					<!-- Table -->

					<CharacterTable
						class="max-w-7xl text-sm w-full"
						characters={results}
					/>
					
				{:else if parameters.layout === 'graph'}

					<!-- Graph -->

					<Empty class="h-96 max-w-7xl w-full"
						icon="Graph" text="This layout type isn't working yet. Try again later."
					/>


				{/if}
			{:else}

				<!-- Empty -->

				<Empty
					icon="User"
					text="There are no characters for this project yet."
					buttonLabel="Create one?"
					buttonClick={() => characters.openModal('create')}
				/>

			{/if}
		</Stack>
	{/snippet}
</AuthenticatedLayout>