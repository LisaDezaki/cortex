<script>
	import { onMount } from 'svelte';
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import Box					from '@/Components/Core/Box.svelte'
	import Flex					from '@/Components/Core/Flex.svelte'
	import Grid					from '@/Components/Core/Grid.svelte'
	import Empty     		 	from '@/Components/UI/Empty.svelte'
	import PageHeader		 	from '@/Components/UI/PageHeader.svelte'
	import Section      	 	from '@/Components/UI/Section.svelte'
	import FactionCard 		 	from '@/Components/Features/Faction/FactionCard.svelte'
	import FactionControlBar 	from '@/Components/Features/Faction/FactionControlBar.svelte'
	import FactionGrid 		 	from '@/Components/Features/Faction/FactionGrid.svelte'
	import FactionPanel 	 	from '@/Components/Features/Faction/FactionPanel.svelte'
	import FactionTable 	 	from '@/Components/Features/Faction/FactionTable.svelte'


	//	Page props

	import ProjectObject 	from '@/services/ProjectObject'
	import CollectionList 	from '@/services/CollectionList'
	const activeProject   = new ProjectObject($page.props.activeProject.data)
	const collections	  = new CollectionList($page.props.collections?.data)
	const characters      = $state(activeProject?.characters)
	const factions    	  = $state(activeProject?.factions)
	const locations    	  = $state(activeProject?.locations)

	let urlParams = new URLSearchParams(typeof window !== 'undefined' ? window.location.search : '');
	

	//	Reactive State

	let parameters = $state({
		query: 		urlParams.get('q')		|| '',
		filter: 	urlParams.get('filter') || '',
		sort: 		urlParams.get('sort')	|| 'name',
		direction: 	urlParams.get('dir') 	|| 'desc',
		size: 		urlParams.get('size') 	|| 6,
		layout: 	urlParams.get('layout') || 'grid',
		selected: 	urlParams.get('selected') || ''
	})

	let gridCols = $derived(12-parameters.size)
	let results = $derived(factions.items)


	/**
	 * Sync with URL
	 * Update filters from URL on Mount
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
	 * Update URL
	 * Update URL params (without page reload) when filters change
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
	 * Get Subtitle
	 * @param character A CharacterObject class instance
	 * @return {string} Subtitle to display on Character Cards
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
	 * @param faction A FactionObject class instance
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
		<Section gap={0} class="h-full overflow-hidden">


			<PageHeader class="px-16 py-3"
				title="Faction List"
				tabs={[
					{ label: "List",		active: true },
					// { label: "Collections",	href: route('factions.collections') },
					{ label: "Settings",	href: route('factions.settings') },
				]}
				actions={[
					{ icon: "Plus", label: "New", theme: "accent", onclick: () => factions.create() },
				]}
			/>


			<FactionControlBar class="px-16 pb-1.5"
				data={factions} project={activeProject}
				bind:query={parameters.query}
				bind:filter={parameters.filter}
				bind:sort={parameters.sort}
				bind:size={parameters.size}
				bind:layout={parameters.layout}
				bind:results={results}
				min={4} max={8}
			/>


			<Flex align="start" class="px-16 pt-3 pb-6 overflow-y-auto">
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