<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import Empty     		 	from '@/Components/UI/Empty.svelte'
	import PageHeader		 	from '@/Components/UI/PageHeader.svelte'
	import Section      	 	from '@/Components/UI/Section.svelte'
	import Thumbnail      	 	from '@/Components/UI/Thumbnail.svelte'
	import FactionCard 		 	from '@/Components/Features/Faction/FactionCard.svelte'
	import FactionControlBar 	from '@/Components/Features/Faction/FactionControlBar.svelte'
	import FactionGrid 		 	from '@/Components/Features/Faction/FactionGrid.svelte'
	import FactionTable 	 	from '@/Components/Features/Faction/FactionTable.svelte'


	//	Page props

	import ProjectObject 	from '@/services/ProjectObject'
	import CollectionList 	from '@/services/CollectionList'
	const activeProject   = new ProjectObject($page.props.activeProject.data)
	const collections	  = new CollectionList($page.props.collections?.data)
	const characters      = $state(activeProject?.characters)
	const factions    	  = $state(activeProject?.factions)
	const locations    	  = $state(activeProject?.locations)
	

	//	State & Derived values

	let query	 = $state('')
	let filter	 = $state('')
	let sort	 = $state('name')
	let size	 = $state(8)
	let layout   = $state('grid')
	let gridCols = $derived(16-size)
	let results = $derived(factions.items)

	function getSubtitle(faction) {
		switch (sort) {
			case 'members':
				return faction.members?.items.length + ' Members'
			case 'created_at':
				return new Date(faction.meta?.createdAt).toLocaleString() || '--'
			case 'updated_at':
				return new Date(faction.meta?.updatedAt).toLocaleString() || '--'
			default:
				return faction.type
		}
	}
	
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
				{ icon: "Plus", label: "Create Faction", theme: "accent", onclick: () => factions.create() },
			]}
		/>
	{/snippet}
	
	{#snippet article()}

		{#if activeProject}
			<FactionControlBar
				data={factions} project={activeProject}
				bind:query bind:filter bind:sort
				bind:results bind:size bind:layout
			/>
		{/if}

		<Section gap={6} class="px-20 py-6">
			{#if activeProject && results.length > 0}


				<!-- Grid -->

				{#if layout == 'grid'}
					<FactionGrid
						factions={results}
						cols={gridCols}
					>
						{#snippet gridItem(faction)}
							<FactionCard starrable
								faction={faction}
								subtitle={getSubtitle(faction)}
								href={faction.routes.show}
								iconOptions={[
									{ icon: "Star", 		onclick: () => faction.star(), iconWeight: faction.starred ? 'fill' : 'regular' },
									{ icon: "Eye", 			href: faction.routes.show },
									{ icon: "Textbox", 		onclick: () => faction.rename() },
									{ icon: "UploadSimple", onclick: () => faction.addEmblem() },
									{ icon: "Trash", 		onclick: () => faction.delete(), theme: "danger" },
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

				{:else if layout == 'table'}
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
		</Section>
	{/snippet}
    
</AuthenticatedLayout>