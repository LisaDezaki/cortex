<script>

	import { onMount } from 'svelte';
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import Grid					from '@/Components/Core/Grid.svelte'
	import Stack				from '@/Components/Core/Stack.svelte'
	import ControlBar			from '@/Components/UI/ControlBar.svelte'
	import Empty     		 	from '@/Components/UI/Empty.svelte'
	import Entity     		 	from '@/Components/UI/Entity.svelte'
	import PageHeader		 	from '@/Components/UI/PageHeader.svelte'
	import PageHeading		 	from '@/Components/UI/PageHeading.svelte'
	import FactionTable 	 	from '@/Components/Features/Faction/FactionTable.svelte'
	import ProjectObject 		from '@/services/ProjectObject'


	/**
	 * Active project instance
	 * @type {ProjectObject}
	 */
	const activeProject   = $state(new ProjectObject($page.props.activeProject.data))
	const factions    	  = $state(activeProject?.factions)


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
	let results = $derived(factions.items)


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
	 * Generate subtitle text for faction cards based on current sort criteria
	 * @param {FactionObject} faction | A FactionObject class instance
	 * @returns {string} subtitle to display on Faction Cards
	 */
	function getSubtitle(faction) {
		switch (parameters.sort) {
			case 'members':
				return faction.members?.items.length + ' Members'
			case 'created_at':
				return faction.meta.created.ago || '--'
			case 'updated_at':
				return faction.meta.updated.ago || '--'
			default:
				if (parameters.sort?.includes('cf.')) {
					return faction.customFieldValues.find(v => v.name === parameters.sort.split('.')[1])?.displayValue || '--'
				} else {
					return faction.type || '--'
				}
		}
	}


	/**
	 * Select Faction
	 * @param {FactionObject} faction | A FactionObject class instance
	 * @return {void}
	 */
	// function selectFaction(faction) {
	// 	const url = new URL(window.location);
	// 	url.searchParams.set('selected', faction?.slug)
	// 	parameters.selected = parameters.selected === faction.slug ? null : faction.slug
	// }
	
</script>



<svelte:head>
    <title>Faction List</title>
</svelte:head>

<AuthenticatedLayout>	
	{#snippet article()}
		<Stack class="overflow-y-auto px-20 py-12">

			<PageHeading
				title="Faction List"
				subtitle="Index page"
				actions={[
					{ icon: "GearFine", theme: "neutral", href: route('factions.settings') },
					{ icon: "Plus", text: "New", theme: "accent", onclick: () => factions.openModal('create') },
				]}
			/>

			<ControlBar class="py-3"
				data={factions} bind:results
				bind:layout={parameters.layout} bind:sort={parameters.sort} bind:size={parameters.size}
				filterOptions={activeProject.getOptions('factions', 'filter')}
				sortOptions={activeProject.getOptions('factions', 'sort')}
				layoutOptions={activeProject.getOptions('factions', 'layout')}
				sizeOptions={{ min: 3, max: 7 }}
				resizeable={parameters.layout === 'grid'}
			/>

			{#if activeProject && factions.items.length > 0}


				<!-- Grid -->

				{#if parameters.layout == 'grid'}
					<Grid class="py-3 w-full" cols={gridCols} gap={3}>
						{#if results.length > 0}
							{#each results as faction}
								<Entity
									active={parameters.selected === faction.slug}
									entity={faction}
									subtitle={getSubtitle(faction)}
									href={faction.routes.show}
								/>
							{/each}
						{:else}
							<Empty class="col-span-full" icon="Empty" text="No results found. Try changing your filters." />
						{/if}
					</Grid>
				

				<!-- Table -->

				{:else if parameters.layout == 'table'}
					<FactionTable
						class="max-w-7xl text-sm w-full"
						factions={results}
					/>


				{/if}
			{:else}

				<Empty
					icon="FlagBannerFold"
					text="There are no factions for this project yet."
					buttonLabel="Create one?"
					buttonClick={() => factions.openModal('create')}
				/>

			{/if}


		</Stack>
	{/snippet}
</AuthenticatedLayout>