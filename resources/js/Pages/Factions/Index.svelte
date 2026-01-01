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
	import FactionPanel 	 	from '@/Components/Features/Faction/FactionPanel.svelte'
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
		size: 		urlParams.get('size')	  || 6,
		layout: 	urlParams.get('layout')	  || 'grid',
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
	let results = $derived(factions.items)


	/**
	 * Sync with URL - Update filters from URL on component mount
	 * @returns {void}
	 */
	onMount(() => {
		urlParams = new URLSearchParams(window.location.search);
		parameters = {
			size: 		urlParams.get('size') 	  || 6,
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
				return new Date(faction.meta?.createdAt).toLocaleString() || '--'
			case 'updated_at':
				return new Date(faction.meta?.updatedAt).toLocaleString() || '--'
			default:
				return faction.type || '--'
		}
	}


	/**
	 * Select Faction
	 * @param {FactionObject} faction | A FactionObject class instance
	 * @return {void}
	 */
	function selectFaction(faction) {
		const url = new URL(window.location);
		url.searchParams.set('selected', faction?.slug)
		parameters.selected = parameters.selected === faction.slug ? null : faction.slug
	}
	
</script>



<svelte:head>
    <title>Faction List</title>
</svelte:head>

<AuthenticatedLayout>	
	{#snippet article()}

		<!-- Fixed/Sticky Header -->

		<PageHeader size="7xl" class="px-20 py-2"
			tabs={[
				{ text: "Faction List",	active: true },
				{ text: "Settings",		href: route('factions.settings') },
			]}
			actions={[
				{ icon: "Plus", text: "New", theme: "accent", onclick: () => factions.create() },
			]}
		>
			<ControlBar
				data={factions} bind:results bind:layout={parameters.layout}
				filterOptions={activeProject.getOptions('factions', 'filter')}
				sortOptions={activeProject.getOptions('factions', 'sort')}
				layoutOptions={activeProject.getOptions('factions', 'layout')}
			/>
		</PageHeader>


		<!-- Main Body -->

		<Stack align="center" class="flex-1 overflow-y-auto px-20 pt-3 pb-12">
			{#if activeProject && factions.items.length > 0}


				<!-- Grid -->

				{#if parameters.layout == 'grid'}
					<Grid class="max-w-7xl w-full" cols={gridCols} gap={3}>
						{#if results.length > 0}
							{#each results as faction}
								<Entity
									active={parameters.selected === faction.slug}
									entity={faction}
									layout="stack"
									size="auto"
									onclick={() => selectFaction(faction)}
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
					buttonClick={() => factions.create()}
				/>

			{/if}


		</Stack>
	{/snippet}

	{#snippet sidebar()}
		<FactionPanel faction={factions.items.find(f => f.slug === parameters.selected)} />
	{/snippet}
</AuthenticatedLayout>