<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import CreateLocationForm 	from '@/Forms/Location/Create.svelte'
	import DeleteLocationForm 	from '@/Forms/Location/Delete.svelte'
	import RenameLocationForm 	from '@/Forms/Location/Rename.svelte'
	import CreateCollectionForm from '@/Forms/Collection/Create.svelte'
	import ApplyTagsForm		from '@/Forms/Tags/Apply.svelte'

	import Empty   from '@/Components/UI/Empty.svelte'
	import Modal      from '@/Components/UI/Modal.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import Section    from '@/Components/UI/Section.svelte'
	
	import LocationCard		from '@/Components/Features/Location/LocationCard.svelte'
	import LocationControlBar from '@/Components/Features/Location/LocationControlBar.svelte'
	import LocationGrid		from '@/Components/Features/Location/LocationGrid.svelte'
	import LocationTable	from '@/Components/Features/Location/LocationTable.svelte'
	import LocationMap		from '@/Components/Features/Location/Map.svelte'
	
	//	Page props
	const activeProject = $page.props.activeProject.data
	const collections	= $page.props.collections?.data
	const worldTree     = $page.props.worldTree?.data
	const locations     = activeProject?.locations  || []

	//	State
	let filteredLocations   = $state(locations)
	let selectedLocation 	= $state(null)
	let layout    			= $state('grid')
	let rowSize   			= $state(5)

	let gridCols 			= $derived(10-rowSize)

	//	State > Modals
	let creatingLocation	= $state(false)
	let deletingLocation	= $state(false)
	let renamingLocation	= $state(false)
	let creatingCollection	= $state(false)
	let applyingTags		= $state(false)

	const applyTags			= (l) => { applyingTags 		= true, selectedLocation = l; }
	const createLocation	= ( ) => { creatingLocation 	= true }
	const createCollection	= (l) => { creatingCollection 	= true,	selectedLocation = l; }
	const deleteLocation	= (l) => { deletingLocation 	= true,	selectedLocation = l; }
	const renameLocation	= (l) => { renamingLocation 	= true,	selectedLocation = l; }
	const closeModal		= ( ) => {  selectedLocation	= null
										applyingTags 		= false
										creatingLocation	= false
										creatingCollection	= false
										deletingLocation	= false
										renamingLocation	= false
									}

	//	Add Character to Collection
	const addToCollectionForm = useForm({
		items: [{ id: null, type: 'locations' }]
	})

	function addToCollection (loc, coll) {
		$addToCollectionForm.items[0]  = { id: loc.id, type: 'locations' }
		$addToCollectionForm.patch(
			route('collections.update', { collection: coll.slug })
		)
	}

	// function updateControls(filteredList, controls) {
	// 	locationList = filteredList
	// 	layout = controls.layout
	// }

</script>

<svelte:head>
    <title>Location List</title>
</svelte:head>





<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			title="Location List"
			tabs={[
				{ icon: "ListBullets",	label: "List",			active: true },
				{ icon: "SquaresFour",	label: "Collections",	href: route('locations.collections') },
				{ icon: "GearFine",		label: "Settings",		href: route('locations.settings') },
			]}
			actions={[
				{ icon: "Plus",			label: "Create", 		onclick: createLocation, theme: "accent" },
			]}
		/>
	{/snippet}

	{#snippet article()}

		{#if activeProject}
			<LocationControlBar
				data={locations}
				bind:filteredData={filteredLocations}
				project={activeProject}
			/>
		{/if}

		<Section gap={6} class="px-12">
			{#if activeProject && locations?.length > 0}

			
				<!-- Grid -->

				{#if layout == 'grid'}
					<LocationGrid
						locations={filteredLocations}
						cols={gridCols}
					>
						{#snippet gridItem(location)}
							<LocationCard
								location={location}
								options={[
									{ label: "View",   icon: "Eye", href: route('locations.show', {location: location.slug}) },
									{ label: "Rename", icon: "Textbox", onclick: () => renameLocation(location) },
									{ separator: true },
									{ label: "Add to Collection",	icon: "FolderSimple",
										options: collections?.length > 0 ? [
											...collections.map(c => {
												return {
													label: c.name,
													icon: "FolderSimple",
													onclick: () => addToCollection(location, c),
													disabled: c.items.map(i => i.collectionable_id).includes(location.id),
													iconWeight: c.items.map(i => i.collectionable_id).includes(location.id) ? 'fill' : 'light' }
											}),
											{ label: "New Collection", icon: "Plus", onclick: () => createCollection(location), theme: "accent" }
										] : undefined
									},
									{ label: "Add Tags", icon: "TagSimple", onclick: () => applyTags(location) },
									{ separator: true },
									{ label: "Delete Location", icon: "Trash",		onclick: () => deleteLocation(location), theme: "danger" }
								]}
							/>
						{/snippet}
					</LocationGrid>


				<!-- Table -->
				
				{:else if layout == 'table'}
					<LocationTable
						locations={filteredLocations}
					/>

				
				<!-- Map -->

				{:else if layout == 'map'}
					<LocationMap
						constrain={false}
						class="bg-black/50 max-h-full rounded-lg"
						location={worldTree}
					/>


				{/if}
			{:else}

				<Empty
					icon="MapPin"
					message="There are no locations for this project yet."
					buttonLabel="Create one?"
					buttonClick={createLocation}
				/>

			{/if}
		</Section>
	{/snippet}
    
</AuthenticatedLayout>

<Modal title="Apply Tags" show={applyingTags} maxWidth="lg"
	onclose={closeModal}>
	<ApplyTagsForm type="locations" entity={selectedLocation || null}
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>

<Modal title="Create a new location" show={creatingLocation} maxWidth="lg"
	onclose={closeModal}>
	<CreateLocationForm
		onSuccess={closeModal} />
</Modal>

<Modal title="Rename {selectedLocation?.name}?" show={renamingLocation} maxWidth="lg"
	onclose={closeModal}>
	<RenameLocationForm location={selectedLocation || null}
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>

<Modal title="Delete {selectedLocation?.name}?" show={deletingLocation} maxWidth="lg"
	onclose={closeModal}>
	<DeleteLocationForm location={selectedLocation || null}
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>

<Modal title="Create Collection" show={creatingCollection} maxWidth="lg"
	onclose={closeModal}>
	<CreateCollectionForm type="locations" entity={selectedLocation || null}
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>