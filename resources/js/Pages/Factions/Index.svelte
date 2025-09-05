<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import ApplyTagsForm		from '@/Forms/Tags/Apply.svelte'
	import CreateCollectionForm from '@/Forms/Collection/Create.svelte'
	import CreateFactionForm 	from '@/Forms/Faction/Create.svelte'
	import DeleteFactionForm 	from '@/Forms/Faction/Delete.svelte'
	import RenameFactionForm 	from '@/Forms/Faction/Rename.svelte'

	import Empty     	from '@/Components/UI/Empty.svelte'
	import Modal		from '@/Components/UI/Modal.svelte'
	import PageHeader	from '@/Components/UI/PageHeader.svelte'
	import Section      from '@/Components/UI/Section.svelte'

	import FactionCard 	from '@/Components/Features/Faction/FactionCard.svelte'
	import FactionControlBar from '@/Components/Features/Faction/FactionControlBar.svelte'
	import FactionGrid 	from '@/Components/Features/Faction/FactionGrid.svelte'
	import FactionTable from '@/Components/Features/Faction/FactionTable.svelte'

	//	Page props
	const activeProject = $page.props.activeProject.data
	const collections	= $page.props.collections?.data
	const factions      = activeProject?.factions

	//	State
	let factionList 	= $state(factions)
	let selectedFaction = $state(null)
	let layout    		= $state('grid')
	let rowSize   		= $state(8)

	//	State > Modals
	let creatingFaction		= $state(false)
	let deletingFaction		= $state(false)
	let renamingFaction		= $state(false)
	let creatingCollection	= $state(false)
	let applyingTags		= $state(false)

	let gridRows    		= $derived( 16-rowSize )

	const applyTags			= (f) => { applyingTags = true,			selectedFaction = f; }
	const createFaction		= ( ) => { creatingFaction 	= true }
	const createCollection	= (f) => { creatingCollection = true,	selectedFaction = f; }
	const deleteFaction		= (f) => { deletingFaction = true,		selectedFaction = f; }
	const renameFaction		= (f) => { renamingFaction = true,		selectedFaction = f; }
	const closeModal		= ( ) => {  selectedFaction	= null
										applyingTags = false
										creatingFaction	= false
										creatingCollection = false
										deletingFaction	= false
										renamingFaction	= false
									}

	//	Add faction to Collection
	const addToCollectionForm = useForm({
		items: [{ id: null, type: 'factions' }]
	})

	function addToCollection(char, coll) {
		$addToCollectionForm.items[0]  = { id: char.id, type: 'factions' }
		$addToCollectionForm.patch(
			route('collections.update', { collection: coll.slug })
		)
	}

	function updateControls(filteredList, controls) {
		factionList = filteredList
		layout = controls.layout
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
			onUpdate={updateControls}
		/>

		<Section gap={6} class="px-12 py-6">
			{#if activeProject && factions?.length > 0}


				<!-- Grid -->

				{#if layout == 'grid'}
					<FactionGrid
						factions={factionList}
						cols={gridRows}
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
												return { label: c.name, icon: "FolderSimple", onclick: () => addToCollection(faction, c) }
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
						factions={factionList}
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

<Modal
	title="Apply Tags"
	maxWidth="lg"
	show={applyingTags}
	onclose={closeModal}
>
	<ApplyTagsForm type="characters" entity={selectedFaction || null} oncancel={closeModal} />
</Modal>

<Modal
	title="Create a new character"
	maxWidth="lg"
	show={creatingFaction}
	onclose={closeModal}
>
	<CreateFactionForm oncancel={closeModal} />
</Modal>

<Modal
	title="Rename {selectedFaction?.name}?"
	maxWidth="lg"
	show={renamingFaction}
	onclose={closeModal}
>
	<RenameFactionForm faction={selectedFaction || null} oncancel={closeModal} />
</Modal>

<Modal
	title="Delete {selectedFaction?.name}?"
	maxWidth="lg"
	show={deletingFaction}
	onclose={closeModal}
>
	<DeleteFactionForm faction={selectedFaction || null} oncancel={closeModal} />
</Modal>

<Modal
	title="Create Collection"
	maxWidth="lg"
	show={creatingCollection}
	onclose={closeModal}
>
	<CreateCollectionForm type="characters" entity={selectedFaction || null} oncancel={closeModal} />
</Modal>