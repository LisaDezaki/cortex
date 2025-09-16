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
	const closeModal		= ( ) => {  creatingFaction		= false
										deletingFaction		= false
										renamingFaction		= false
										creatingCollection 	= false
										applyingTags 		= false
										setTimeout(() => selectedFaction = null, 300)
									 }

	//	Add faction to Collection
	const addToCollectionForm = useForm({
		items: [{ id: null, type: 'factions' }]
	})

	let selectedFactionName = $derived(selectedFaction?.name || '')

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
				{ label: "List",			active: true },
				{ label: "Collections",	href: route('factions.collections') },
				{ label: "Settings",		href: route('factions.settings') },
			]}
			actions={[
				{ icon: "Plus",			label: "Create Faction", onclick: createFaction, theme: "accent" },
			]}
		/>
	{/snippet}
	
	{#snippet article()}

		<FactionControlBar
			data={factions}
			bind:filteredData={filteredFactions}
			project={activeProject}
		/>

		<Section gap={6} class="px-12 py-6">
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
								iconOptions={[
									{ icon: "Eye", 		href: route('factions.show', {faction: faction.slug}) },
									{ icon: "Textbox", 	onclick: () => renameFaction(faction) },
									{ icon: "Star", 	onclick: () => renameFaction(faction) },
									{ icon: "Trash", 	onclick: () => deleteFaction(character), theme: "danger" },
								]}
								options={[{
									label: "Add to Collection",
									create: () => createCollection(faction),
									options: [ ...collections.map(c => ({
										label: c.name,
										onclick: () => addToCollection(faction, f),
										disabled: f.items.map(i => i.collectionable_id).includes(character.id),
										iconWeight: f.items.map(i => i.collectionable_id).includes(character.id) ? 'fill' : 'light'
									}))]
								},{
									label: "Add Tags",
									onclick: () => applyTags(faction)
								},{
									label: "Add Character"
								},{
									label: "Set Location"
								},{
									separator: true
								},{
									label: "Delete Faction",
									onclick: () => deleteFaction(faction),
									theme: "danger"
								}
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





<CreateFactionForm isOpen={creatingFaction}
	onSuccess={closeModal} oncancel={closeModal}
/>
<RenameFactionForm isOpen={renamingFaction} faction={selectedFaction}
	onSuccess={closeModal} oncancel={closeModal}
/>
<DeleteFactionForm isOpen={deletingFaction} faction={selectedFaction}
	onSuccess={closeModal} oncancel={closeModal}
/>
<CreateCollectionForm isOpen={creatingCollection} entity={selectedFaction} type="factions"
	onSuccess={closeModal} oncancel={closeModal}
/>
<ApplyTagsForm isOpen={applyingTags} entity={selectedFaction} type="factions"
	onSuccess={closeModal} oncancel={closeModal}
/>