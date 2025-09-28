<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import Empty     		 	from '@/Components/UI/Empty.svelte'
	import PageHeader		 	from '@/Components/UI/PageHeader.svelte'
	import Section      	 	from '@/Components/UI/Section.svelte'
	import FactionCard 		 	from '@/Components/Features/Faction/FactionCard.svelte'
	import FactionControlBar 	from '@/Components/Features/Faction/FactionControlBar.svelte'
	import FactionGrid 		 	from '@/Components/Features/Faction/FactionGrid.svelte'
	import FactionTable 	 	from '@/Components/Features/Faction/FactionTable.svelte'


	//	Page props

	import ProjectObject 	from '@/services/ProjectObject'
	import CollectionList 	from '@/services/CollectionList'
	import CharacterList 	from '@/services/CharacterList'
	import FactionList 		from '@/services/FactionList'
	import LocationList 	from '@/services/LocationList'
	const activeProject   = new ProjectObject($page.props.activeProject.data)
	const collections	  = new CollectionList($page.props.collections?.data)
	const characters      = new CharacterList(activeProject?.characters)
	const factions        = new FactionList(activeProject?.factions)
	const locations    	  = new LocationList(activeProject?.locations)
	

	//	State & Derived values

	// let filteredFactions 	= $state(factions)
	// let selectedFaction 	= $state(null)
	// let layout    			= $state('grid')
	let query	 = $state('')
	let filter	 = $state('')
	let sort	 = $state('name.asc')
	let layout   = $state('grid')
	let size	 = $state(8)
	let rowSize  = $state(8)
	let gridCols = $derived(16-rowSize)


	//	Modal Management

	import { modalActions } from '@/stores/modalStore';
	// function createCharacter() 		{ modalActions.open('createCharacter') 	}
	function createFaction()		{ modalActions.open('createFaction') 	}
	// function createLocation()		{ modalActions.open('createLocation') 	}
	function createCollection(type)	{ modalActions.open('createCollection', { type }) }
	function deleteFaction(fac) 	{ modalActions.open('deleteFaction', 	{ faction: fac 		}) }
	function renameFaction(fac) 	{ modalActions.open('renameFaction', 	{ faction: fac 		}) }

</script>



<svelte:head>
    <title>Faction List</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			title="Faction List"
			tabs={[
				{ label: "List",		active: true },
				{ label: "Collections",	href: route('factions.collections') },
				{ label: "Settings",	href: route('factions.settings') },
			]}
			actions={[
				{ icon: "Plus", label: "Create Faction", onclick: () => factions.create(), theme: "accent" },
			]}
		/>
	{/snippet}
	
	{#snippet article()}

		{#if activeProject}
			<FactionControlBar
				data={factions}
				bind:query bind:filter
				bind:sort  bind:layout
				bind:size
				project={activeProject}
			/>
		{/if}

		<Section gap={6} class="px-12 py-6">
			{#if activeProject && factions.items?.length > 0}


				<!-- Grid -->

				{#if layout == 'grid'}
					<FactionGrid
						factions={factions.items}
						cols={gridCols}
					>
						{#snippet gridItem(faction)}
							<FactionCard
								faction={faction}
								href={faction.routes.show}
								iconOptions={[
									{ icon: "Star", 	onclick: () => faction.star(), iconWeight: faction.starred ? 'fill' : 'regular' },
									{ icon: "Eye", 		href: faction.routes.show },
									{ icon: "Textbox", 	onclick: () => faction.rename() },
									{ icon: "Trash", 	onclick: () => faction.delete(), theme: "danger" },
								]}
								options={[{
									label: "Add to Collection",
									create: () => collections.create(),
									options: [ ...collections.items.map(c => ({
										label: c.name,
										onclick: () => faction.addToCollection(c),
										disabled:   c.items.map(i => i.collectionable_id).includes(faction.id),
										iconWeight: c.items.map(i => i.collectionable_id).includes(faction.id) ? 'fill' : 'light'
									}))]
								},{
									label: "Add Tags",
									onclick: () => faction.applyTags()
								},{
									label: "Add Member",
									options: [ ...characters.items.map(c => ({
										label: c.name,
										onclick: () => faction.addMember(c)
									})) ]
								},{
									label: "Set Headquarters",
									hideIf: faction.headquarters != null,
									options: [ ...locations.items.map(l => ({
										label: l.name,
										onclick: () => faction.setHeadquarters(l)
									})) ]
								},{
									label: "Remove Headquarters",
									hideIf: faction.headquarters == null,
									onclick: () => faction.removeHeadquarters()
								},{
									separator: true
								},{
									label: "Delete Faction",
									onclick: () => faction.delete(),
									theme: "danger"
								}
								]}
							/>
						{/snippet}
					</FactionGrid>
				

				<!-- Table -->

				{:else if layout == 'table'}
					<FactionTable
						factions={factions}
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
		</Section>
	{/snippet}
    
</AuthenticatedLayout>