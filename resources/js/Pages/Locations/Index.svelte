<script>
	import { Link, page, router, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import ApplyTagsForm		from '@/Forms/Tags/Apply.svelte'
	import CreateCollectionForm from '@/Forms/Collection/Create.svelte'
	import CreateLocationForm 	from '@/Forms/Location/Create.svelte'
	import DeleteLocationForm 	from '@/Forms/Location/Delete.svelte'
	import RenameLocationForm 	from '@/Forms/Location/Rename.svelte'

	import { Flex, Inline, Stack } from '@/Components/Core'
	import Dropdown   from '@/Components/UI/Dropdown.svelte'
	import Empty   from '@/Components/UI/Empty.svelte'
	import Icon       from '@/Components/UI/Icon.svelte'
	import Input      from '@/Components/UI/Input.svelte'
	import Modal      from '@/Components/UI/Modal.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import Section    from '@/Components/UI/Section.svelte'
	
	import LocationCard		from '@/Components/Features/Location/LocationCard.svelte'
	import LocationGrid		from '@/Components/Features/Location/LocationGrid.svelte'
	import LocationTable	from '@/Components/Features/Location/LocationTable.svelte'
	import Map				from '@/Components/Features/Location/Map.svelte'
	
	//	Page props
	const activeProject = $page.props.activeProject.data
	const collections	= $page.props.collections?.data
	const customFields  = $page.props.customFields?.data
	const tags			= $page.props.tags?.data
	const worldTree     = $page.props.worldTree?.data

	const characters    = activeProject?.characters || []
	const locations     = activeProject?.locations  || []

	//	State
	let selectedLocation = $state(null)
	let columns   = $state(['name', 'locations'])
	let filter    = $state({})
	let layout    = $state('grid')
	let query     = $state('')
	let rowSize   = $state(5)
	let sortBy    = $state('name')
	let sortOrder = $state('asc')
	let filteredLocations = $state(locations)
	let selectedLocations = $state([])
	let locationModalOpen       = $state(false)
	let deleteLocationModalOpen = $state(false)
	let deleteRegionModalOpen   = $state(false)
	let activeLocation    = $state(null)

	//	State > Modals
	let applyingTags		= $state(false)
	let creatingLocation	= $state(false)
	let creatingCollection	= $state(false)
	let deletingLocation	= $state(false)
	let renamingLocation	= $state(false)

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
	const addToCollection = (loc, coll) => {
		$addToCollectionForm.items[0]  = { id: loc.id, type: 'locations' }
		$addToCollectionForm.patch(
			route('collections.update', { collection: coll.slug })
		)
	}

	//	Derived
	let gridCols     = $derived(10-rowSize)
	let hasFilter    = $derived(Boolean(filter.name && filter.value))
	let locationList = $derived(
		locations
			.filter(c => {
				if (query.length > 0 && !c.name.toLowerCase().includes(query.toLowerCase())) { return false }
				// if (hasFilter && filter.name === 'Faction' && c.factions[0]?.name !== filter.value) { return false }
				if (!['Faction', 'Location', 'Relationship'].includes(filter.name) && filter.value && c.customFieldValues?.find(f => f.field?.label === filter.name)?.value !== filter.value) { return false }
				return true
			}).sort((a, b) => {
				if (sortBy === 'name')    { return a.name > b.name                       ? 1 : -1 }
				if (sortBy === 'type')    { return a.type > b.type                       ? 1 : -1 }
				if (sortBy === 'parent')  { return a.parent?.name > b.parent?.name       ? 1 : -1 }
				if (sortBy === 'created') { return a.meta.created_at > b.meta.created_at ? 1 : -1 }
				if (sortBy === 'updated') { return a.meta.created_at > b.meta.created_at ? 1 : -1 }
				if (sortBy === 'random')  { return Math.random() > 0.5                   ? 1 : -1 }
			})
	)

	function filterLocations(e) {
		filteredLocations = query.length == 0
			? locations
			: locations.filter(c => {
				let string = `${c.name} ${c.alias}`;
				return string.toLowerCase().includes(e.target.value.toLowerCase());
			})
	}

	function removeFilter(index) {
		filter = {}
	}

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
		<!-- <PageHeader
			breadcrumbs={[]}
			back={route('dashboard')}
			title={layout == 'map' ? "World Map" : "Location List"}
			actions={[
				{ icon: "Plus",     theme: "accent" },
				{ icon: "GearFine", theme: "neutral", href: route('locations.settings') },
			]}
		> -->
			
		<!-- </PageHeader> -->
	{/snippet}

	{#snippet article()}

		<Flex align="start" gap={3}
			class="backdrop-blur-lg bg-white/50 border-b border-neutral-softest absolute top-0 left-0 px-12 py-3 w-full z-50"
		>

			<!-- Search -->

			<Input type="search" bind:value={query} class="w-48"
				icon="MagnifyingGlass" name="search" placeholder="Search..."
			/>

			<!-- Filter -->

			<Dropdown class="w-48" contentClass="w-48" icon="FunnelSimple" label="All locations..." bind:value={filter} options={[
				{ label: 'Nameless',   value: 'noname' },
				{ label: 'Incomplete', value: 'incomplete' },
				{ separator: true },
				// { label: 'Has character...', children: characters.map(c => {
				// 	return { label: c.name, value: `character.${c.slug}`, image: c.portrait?.url }
				// }) },
				...customFields.filter(f => f.type == 'select').map(f => {
					return { label: `${f.label}...`, children: f.options.map(o => {
						return { label: o.label, value: `${f.name}.${o.value}` }
					})}
				})
			]} />

			<!-- Sort -->

			<Input type="select" class="w-48" icon="SortAscending" placeholder="Sort by" bind:value={sortBy} options={[
				{ value: 'name',   label: "By location name" },
				{ value: 'type',   label: "By location type" },
				{ value: 'parent', label: "By parent name" },
				{ separator: true },
				{ value: 'created', label: "Date Created" },
				{ value: 'updated', label: "Date Updated" },
				{ value: 'random',  label: "Randomly" },
			]} />

			<!-- Result Count -->

			<div class="bg-emerald-500/10 text-emerald-500 rounded-lg p-2">{locationList.length} {locationList.length !== 1 ? 'results' : 'result'}</div>

			<!-- Size / Columns -->

			<Inline gap={1.5} class="ml-auto min-w-40 flex-shrink-0">
				{#if layout === 'grid'}
					<Icon name="Resize" size={24} />
					<Input type="slider" class="" showValue={false} min={3} max={7} bind:value={rowSize} />
				{:else if layout === 'table'}
					<Input type="select" multiple
						class="ml-auto"
						bind:value={columns}
						options={[
							{ value: 'name',       label: "Name" },
							{ value: 'locations', label: "Locations" },
							...customFields.map((field) => {
								return { value: field.name, label: field.label }
							})
						]}
					/>
				{/if}
			</Inline>

			<!-- Layout -->

			<Input type="select" class="w-32"
				bind:value={layout}
				options={[
					{ icon: "Compass",  label: "Maps",  value: "map"   },
					{ icon: "GridFour", label: "Grid",  value: "grid"  },
					{ icon: "Table",    label: "Table", value: "table" }
				]}
			/>

		</Flex>

		<Section gap={6} class="p-12 pt-20">
			{#if activeProject && locations?.length > 0}


				<!-- Map -->

				{#if layout == 'map'}
					<Map
						constrain={false}
						class="bg-black/50 max-h-full rounded-lg"
						location={worldTree}
					/>
					

				<!-- Grid -->

				{:else if layout == 'grid'}
					<LocationGrid
						locations={locationList}
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


				<!-- Map -->
				
				{:else if layout == 'table'}
					<LocationTable
						locations={locationList}
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