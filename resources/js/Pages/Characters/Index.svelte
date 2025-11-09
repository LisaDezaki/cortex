<script>

	import { onMount } from 'svelte';
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import Flex					from '@/Components/Core/Flex.svelte'
	import Empty				from '@/Components/UI/Empty.svelte'
	import PageHeader			from '@/Components/UI/PageHeader.svelte'
	import Section				from '@/Components/UI/Section.svelte'
	import CharacterCard		from '@/Components/Features/Character/CharacterCard.svelte'
	import CharacterControlBar 	from '@/Components/Features/Character/CharacterControlBar.svelte'
	import CharacterGrid 		from '@/Components/Features/Character/CharacterGrid.svelte'
	import CharacterPanel 		from '@/Components/Features/Character/CharacterPanel.svelte'
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
	 * @property {string} query - Search query string
	 * @property {string} filter - Current filter type
	 * @property {string} sort - Sort field name
	 * @property {string} direction - Sort direction ('asc' or 'desc')
	 * @property {number} size - Grid size/layout parameter
	 * @property {string} layout - Display layout ('grid' or 'table')
	 * @property {string} selected - Slug of currently selected faction
	 */

	/**
	 * Reactive state parameters for filtering, sorting, and layout
	 * @type {AppParameters}
	 */
	let parameters = $state({
		query: 		urlParams.get('q')		|| '',
		filter: 	urlParams.get('filter') || '',
		sort: 		urlParams.get('sort')	|| 'name',
		direction: 	urlParams.get('dir')	|| 'desc',
		size: 		urlParams.get('size')	|| 6,
		layout: 	urlParams.get('layout')	|| 'grid',
		selected: 	urlParams.get('selected') || ''
	})

	/**
	 * Derived grid columns calculation based on size parameter
	 * @type {number}
	 */
	let gridCols = $derived(12-parameters.size)

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
			query: 		urlParams.get('q') 		|| '',
			filter: 	urlParams.get('filter') || '',
			sort: 		urlParams.get('sort') 	|| 'name',
			direction: 	urlParams.get('dir') 	|| 'desc',
			size: 		urlParams.get('size') 	|| 6,
			layout: 	urlParams.get('layout') || 'grid',
			selected: 	urlParams.get('selected') || ''
		};
	});

	/**
	 * Update URL - Sync URL params with state changes (without page reload)
	 * @returns {void}
	 */
	$effect(() => {
		const url = new URL(window.location);
		if (parameters.query)	{ url.searchParams.set('q', parameters.query); }
		else 					{ url.searchParams.delete('q'); }
		if (parameters.filter)	{ url.searchParams.set('filter', parameters.filter); }
		else					{ url.searchParams.delete('filter'); }
		url.searchParams.set('size',		parameters.size);
		url.searchParams.set('sort',		parameters.sort);
		url.searchParams.set('direction',	parameters.direction);
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
				return new Date(character.meta?.createdAt).toLocaleString() || '--'
			case 'updated_at':
				return new Date(character.meta?.updatedAt).toLocaleString() || '--'
			default:
				return character.customFieldValues.find(v => v.name === parameters.sort)?.displayValue || character.alias
		}
	}

	/**
	 * Select or deselect a character in the UI
	 * @param {CharacterObject} character | A CharacterObject class instance
	 * @return {void}
	 */
	function selectCharacter(character) {
		const url = new URL(window.location);
		url.searchParams.set('selected', character?.slug)
		parameters.selected = parameters.selected === character.slug ? null : character.slug
	}

</script>



<svelte:head>
    <title>Character List</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Section gap={0} class="h-full overflow-y-auto">

			<!-- Fixed/Sticky Header -->

			<PageHeader class="px-20 py-3"
				title="Character List"
				tabs={[
					{ label: "List",		active: true },
					{ label: "Settings",	href: route('characters.settings') },
				]}
				actions={[
					{ icon: "Plus", label: "New", theme: "accent", onclick: () => characters.create() },
				]}
			>
				<CharacterControlBar
					data={characters} project={activeProject}
					bind:query={parameters.query}
					bind:filter={parameters.filter}
					bind:sort={parameters.sort}
					bind:size={parameters.size}
					bind:layout={parameters.layout}
					bind:results
					min={4} max={8}
				/>
			</PageHeader>

			<!-- Main Body -->

			<Flex align="start" class="px-20 pt-3 pb-6">
				{#if activeProject && results.length > 0}
	
					<!-- Grid -->
	
					{#if parameters.layout === 'grid'}
						<CharacterGrid
							characters={results}
							cols={gridCols}
							gap={1.5}
						>
							{#snippet gridItem(character)}
								<CharacterCard
									active={parameters.selected === character.slug}
									character={character}
									subtitle={getSubtitle(character)}
									onclick={() => selectCharacter(character)}
								/>
							{/snippet}
						</CharacterGrid>
					
				
					<!-- Table -->
	
					{:else if parameters.layout === 'table'}
						<CharacterTable
							characters={results}
						/>
	
	
					<!-- Graph -->
	
					{:else if parameters.layout === 'graph'}
						<Empty
							containerClass="px-20 py-6"
							icon="Graph"
							message="This layout type isn't working yet. Try again later."
						/>


					{/if}
				{:else}

					<Empty
						icon="User"
						containerClass="w-full"
						message="There are no characters for this project yet."
						buttonLabel="Create one?"
						buttonClick={() => characters.create()}
					/>

				{/if}
			</Flex>
		</Section>
	{/snippet}
	{#snippet sidebar()}
		<CharacterPanel character={characters.items.find(c => c.slug === parameters.selected)} />
	{/snippet}
</AuthenticatedLayout>