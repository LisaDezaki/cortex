<script>

	import { onMount } from 'svelte';
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import Flex					from '@/Components/Core/Flex.svelte'
	import Empty     		 	from '@/Components/UI/Empty.svelte'
	import PageHeader		 	from '@/Components/UI/PageHeader.svelte'
	import Section      	 	from '@/Components/UI/Section.svelte'
	import FactionCard 		 	from '@/Components/Features/Faction/FactionCard.svelte'
	import FactionControlBar 	from '@/Components/Features/Faction/FactionControlBar.svelte'
	import FactionGrid 		 	from '@/Components/Features/Faction/FactionGrid.svelte'
	import FactionPanel 	 	from '@/Components/Features/Faction/FactionPanel.svelte'
	import FactionTable 	 	from '@/Components/Features/Faction/FactionTable.svelte'
	import ProjectObject 	from '@/services/ProjectObject'


	/**
	 * Active project instance
	 * @type {ProjectObject}
	 */
	const activeProject   = $state(new ProjectObject($page.props.activeProject.data))
	const characters      = $state(activeProject?.characters)
	const factions    	  = $state(activeProject?.factions)
	const locations    	  = $state(activeProject?.locations)


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
		direction: 	urlParams.get('dir') 	|| 'desc',
		size: 		urlParams.get('size') 	|| 6,
		layout: 	urlParams.get('layout') || 'grid',
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
			query: 		urlParams.get('q') 		|| '',
			filter: 	urlParams.get('filter') || '',
			size: 		urlParams.get('size') 	|| 6,
			sort: 		urlParams.get('sort') 	|| 'name',
			direction: 	urlParams.get('dir') 	|| 'desc',
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
		<Section gap={0} class="h-full overflow-y-auto">


			<!-- Fixed/Sticky Header -->

			<PageHeader class="px-20 py-2"
				title="Faction List"
				tabs={[
					{ label: "List",		active: true },
					{ label: "Settings",	href: route('factions.settings') },
				]}
				actions={[
					{ icon: "Plus", label: "New", theme: "accent", onclick: () => factions.create() },
				]}
			>
				<FactionControlBar
					data={factions} project={activeProject}
					bind:query={parameters.query}
					bind:filter={parameters.filter}
					bind:sort={parameters.sort}
					bind:size={parameters.size}
					bind:layout={parameters.layout}
					bind:results={results}
					min={4} max={8}
				/>
			</PageHeader>


			<!-- Main Body -->

			<Flex align="start" class="px-20 pt-3 pb-6">
				{#if activeProject && results.length > 0}

				
					<!-- Grid -->

					{#if parameters.layout == 'grid'}
						<FactionGrid
							factions={results}
							cols={gridCols}
							gap={1.5}
						>
							{#snippet gridItem(faction)}
								<FactionCard
									active={parameters.selected === faction.slug}
									faction={faction}
									subtitle={getSubtitle(faction)}
									onclick={() => selectFaction(faction)}
									iconOptions={[
										{ icon: "Star", 		onclick: () => faction.star(), iconWeight: faction.starred ? 'fill' : 'regular' },
										{ icon: "Eye", 			href: faction.routes.show },
										{ icon: "Textbox", 		onclick: () => faction.openModal('rename') },
										{ icon: "UploadSimple", onclick: () => faction.openModal('setEmblem') },
										{ icon: "Trash", 		onclick: () => faction.openModal('delete'), theme: "danger" },
									]}
									options={[{
										icon: 'HouseLine', iconWeight: 'regular',
										label: "Set Headquarters",
										options: [ ...locations.items.map(l => ({
											...l,
											active: l.id === faction.headquarters?.id,
											label: l.name,
											onclick: () => faction.setHeadquarters(l)
										})) ]
									},{
										icon: 'UserPlus', iconWeight: 'regular',
										label: "Add Member",
										options: [ ...characters.items.map(c => ({
											...c,
											active: faction.members?.items.map(m => m.name.toLowerCase()).includes(c.name.toLowerCase()),
											label: c.name,
											onclick: () => faction.addMember(c)
										})) ]
									},{
										separator: true
									},{
										icon: 'FolderSimple', iconWeight: 'regular',
										label: "Add to Collection",
										create: () => collections.create(),
										options: [ ...collections.items.map(c => ({
											...c,
											label: c.name,
											onclick: () => faction.addToCollection(c),
											disabled:   c.items.map(i => i.collectionable_id).includes(faction.id),
											iconWeight: c.items.map(i => i.collectionable_id).includes(faction.id) ? 'fill' : 'light'
										}))]
									},{
										icon: 'TagSimple', iconWeight: 'regular',
										label: "Add Tags",
										onclick: () => faction.applyTags()
									},{
										separator: true
									},{
										icon: 'Trash', iconWeight: 'regular',
										label: "Delete Faction",
										onclick: () => faction.delete(),
										theme: "danger"
									}
									]}
								/>
							{/snippet}
						</FactionGrid>
					

					<!-- Table -->

					{:else if parameters.layout == 'table'}
						<FactionTable
							factions={results}
						/>


					{/if}
				{:else}

					<Empty
						icon="FlagBannerFold"
						containerClass="w-full"
						message="There are no factions for this project yet."
						buttonLabel="Create one?"
						buttonClick={() => factions.create()}
					/>

				{/if}


			</Flex>
		</Section>
	{/snippet}

	{#snippet sidebar()}
		<FactionPanel faction={factions.items.find(f => f.slug === parameters.selected)} />
	{/snippet}
</AuthenticatedLayout>