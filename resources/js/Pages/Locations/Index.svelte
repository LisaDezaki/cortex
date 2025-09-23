<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import Empty   from '@/Components/UI/Empty.svelte'
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


	//	State & Derived values

	let filteredLocations   = $state(locations)
	let selectedLocation 	= $state(null)
	let layout    			= $state('grid')
	let rowSize   			= $state(5)
	let gridCols 			= $derived(10-rowSize)


	//	Modal Management

	import { modalActions } from '@/stores/modalStore';

	function createCollection() 	{ modalActions.open('createCollection') }
	function createLocation() 		{ modalActions.open('createLocation') 	}
	function deleteLocation(loc) 	{ modalActions.open('deleteLocation', { location: loc }) 	}
	function renameLocation(loc) 	{ modalActions.open('renameLocation', { location: loc }) 	}

	//	Add Character to Collection
	const addToCollectionForm = useForm({
		items: [{ id: null, type: 'locations' }]
	})

	// let selectedLocationName = $derived(selectedLocation?.name ||'')

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
				{ label: "List",		active: true },
				{ label: "Collections",	href: route('locations.collections') },
				{ label: "Settings",	href: route('locations.settings') },
			]}
			actions={[
				{ icon: "Plus",			label: "Create Location", onclick: createLocation, theme: "accent" },
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

		<Section gap={6} class="px-12 py-6">
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
								iconOptions={[
									{ icon: "Eye", 		href: route('locations.show', {location: location.slug}) },
									{ icon: "Textbox", 	onclick: () => renameLocation(location) },
									{ icon: "Star", 	onclick: () => renameLocation(location) },
									{ icon: "Trash", 	onclick: () => deleteLocation(location), theme: "danger" },
								]}
								options={[{
									label: "Add to Collection",
									create: () => createCollection(location),
									options: [ ...collections.map(c => ({
										label: c.name,
										onclick: () => addToCollection(location, c),
										disabled:   c.items.map(i => i.collectionable_id).includes(location.id),
										iconWeight: c.items.map(i => i.collectionable_id).includes(location.id) ? 'fill' : 'light'
									}))]
								},{
									label: "Add Tags",
									onclick: () => applyTags(location)
								},{
									separator: true
								},{
									label: "Delete Location",
									onclick: () => deleteLocation(location),
									theme: "danger"
								}
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