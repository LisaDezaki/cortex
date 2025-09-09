<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import CreateFactionForm 	from '@/Forms/Faction/Create.svelte'
	import DeleteFactionForm 	from '@/Forms/Faction/Delete.svelte'
	import RenameFactionForm 	from '@/Forms/Faction/Rename.svelte'
	import CreateCollectionForm from '@/Forms/Collection/Create.svelte'
	import ApplyTagsForm		from '@/Forms/Tags/Apply.svelte'

	import Empty     	from '@/Components/UI/Empty.svelte'
	import Modal		from '@/Components/UI/Modal.svelte'
	import PageHeader	from '@/Components/UI/PageHeader.svelte'
	import Section      from '@/Components/UI/Section.svelte'

	import FactionCard 	from '@/Components/Features/Faction/FactionCard.svelte'
	import FactionControlBar from '@/Components/Features/Faction/FactionControlBar.svelte'
	import FactionGrid 	from '@/Components/Features/Faction/FactionGrid.svelte'
	import FactionTable from '@/Components/Features/Faction/FactionTable.svelte'

	//	Page props
	const activeProject 	= $page.props.activeProject.data
	const collections		= $page.props.collections?.data
	const factions      	= activeProject?.factions
	
	//	State
	let filteredFactions 	= $state(factions)
	let selectedFaction 	= $state(null)
	let layout    			= $state('grid')
	let rowSize   			= $state(8)

	let gridCols    		= $derived( 16-rowSize )

	//	State > Modals
	let creatingFaction		= $state(false)
	let deletingFaction		= $state(false)
	let renamingFaction		= $state(false)
	let creatingCollection	= $state(false)
	let applyingTags		= $state(false)

	const createFaction		= ( ) => { 	creatingFaction 	= true }
	const deleteFaction		= (f) => { 	deletingFaction 	= true,	selectedFaction = f; }
	const renameFaction		= (f) => { 	renamingFaction 	= true,	selectedFaction = f; }
	const createCollection	= (f) => { 	creatingCollection 	= true,	selectedFaction = f; }
	const applyTags			= (f) => { 	applyingTags 		= true,	selectedFaction = f; }
	const closeModal		= ( ) => {  selectedFaction		= null
										creatingFaction		= false
										deletingFaction		= false
										renamingFaction		= false
										creatingCollection 	= false
										applyingTags 		= false
																	}

	//	Add faction to Collection
	const addToCollectionForm = useForm({
		items: [{ id: null, type: 'factions' }]
	})

	function addToCollection(fac, coll) {
		$addToCollectionForm.items[0]  = { id: fac.id, type: 'factions' }
		$addToCollectionForm.patch(
			route('collections.update', { collection: coll.slug })
		)
	}

	// function updateControls(filteredList, controls) {
	// 	factionList = filteredList
	// 	layout = controls.layout
	// }

</script>

<svelte:head>
    <title>Faction List</title>
</svelte:head>





<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			title="Faction List"
			tabs={[
				{ icon: "ListBullets",	label: "List",			active: true },
				{ icon: "SquaresFour",	label: "Collections",	href: route('factions.collections') },
				{ icon: "GearFine",		label: "Settings",		href: route('factions.settings') },
			]}
			actions={[
				{ icon: "Plus",			label: "Create", 		onclick: createFaction, theme: "accent" },
			]}
		/>
	{/snippet}
	
	{#snippet article()}

		<FactionControlBar
			data={factions}
			bind:filteredData={filteredFactions}
			project={activeProject}
		/>

		<Section gap={6} class="px-12">
			{#if activeProject && factions?.length > 0}


				<!-- Grid -->

				{#if layout == 'grid'}
					<FactionGrid
						factions={filteredFactions}
						cols={gridCols}
					>
						{#snippet gridItem(faction)}
							<FactionCard
								faction={faction}
								options={[
									{ label: "View",   icon: "Eye", href: route('factions.show', {faction: faction.slug}) },
									{ label: "Rename", icon: "Textbox", onclick: () => renameFaction(faction) },
									{ separator: true },
									{ label: "Add to Collection",	icon: "FolderSimple",
										options: [
											...collections.map(c => {
												return {
													label: c.name,
													icon: "FolderSimple",
													onclick: () => addToCollection(faction, f),
													disabled: f.items.map(i => i.collectionable_id).includes(character.id),
													iconWeight: f.items.map(i => i.collectionable_id).includes(character.id) ? 'fill' : 'light' }
												// return { label: c.name, icon: "FolderSimple", onclick: () => addToCollection(faction, c) }
											}),
											{ label: "New Collection", icon: "Plus", onclick: () => createCollection(faction), theme: "accent" }
										]
									},
									{ label: "Add Tags", icon: "TagSimple", onclick: () => applyTags(faction) },
									{ label: "Add Character", icon: "UsersThree" },
									{ label: "Set Location", icon: "MapPinArea" },
									{ separator: true },
									{ label: "Delete Faction", icon: "Trash",		onclick: () => deleteFaction(faction), theme: "danger" }
								]}
							/>
						{/snippet}
					</FactionGrid>
				

				<!-- Table -->

				{:else if layout == 'table'}
					<FactionTable
						factions={filteredFactions}
					/>


				{/if}
			{:else}

				<Empty
					icon="FlagBannerFold"
					message="There are no factions for this project yet."
					buttonLabel="Create one?"
					buttonClick={createFaction}
				/>

			{/if}
		</Section>
	{/snippet}
    
</AuthenticatedLayout>



<Modal title="Create a new faction" show={creatingFaction} maxWidth="lg"
	onclose={closeModal}>
	<CreateFactionForm
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>

<Modal title="Rename {selectedFaction?.name}?" show={renamingFaction} maxWidth="lg"
	onclose={closeModal}>
	<RenameFactionForm faction={selectedFaction || null}
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>

<Modal title="Delete {selectedFaction?.name}?" show={deletingFaction} maxWidth="lg"
	onclose={closeModal}>
	<DeleteFactionForm faction={selectedFaction || null}
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>

<Modal title="Create Collection" show={creatingCollection} maxWidth="lg"
	onclose={closeModal}>
	<CreateCollectionForm type="factions" entity={selectedFaction || null}
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>

<Modal title="Apply Tags" show={applyingTags} maxWidth="lg"
	onclose={closeModal}>
	<ApplyTagsForm type="factions" entity={selectedFaction || null}
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>