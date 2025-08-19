<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import NewLocationForm     from '@/Forms/Location/LocationNew.svelte'
	import LocationGrid        from '@/Partials/LocationGrid.svelte'
	import LocationTable       from '@/Partials/LocationTable.svelte'

	import { Flex, Inline, Stack } from '@/Components/Core'

	import Back       from '@/Components/UI/Back.svelte';
	import Dropdown   from '@/Components/UI/Dropdown.svelte'
	import Heading    from '@/Components/UI/Heading.svelte'
	import Icon       from '@/Components/UI/Icon.svelte'
	import Input      from '@/Components/UI/Input.svelte'
	import Modal      from '@/Components/UI/Modal.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import Section    from '@/Components/UI/Section.svelte'
	
	import Map        from '@/Components/Features/Location/Map.svelte'
	
	const activeProject = $page.props.activeProject.data
	const customFields  = $page.props.customFields?.data
	const worldTree     = $page.props.worldTree?.data
	const characters    = activeProject?.characters || []
	const locations     = activeProject?.locations  || []

	let columns   = $state(['name', 'characters'])
	let filter    = $state({})
	let layout    = $state('map')
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

	function openLocationModal(location) {
		activeLocation = location
        locationModalOpen = true
    }
	function deleteLocationModal(location) {
		activeLocation = location
		deleteLocationModalOpen = true
	}
	function closeModal() {
        locationModalOpen = false
		deleteLocationModalOpen = false
		deleteRegionModalOpen = false
    }

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

	function setTab(tabName) {
		currentTab = tabName
	}

	// function groupByRegion(locations) {
	// 	let regions = [];

	// 	locations = query.length == 0
	// 		? locations
	// 		: locations.filter(c => {
	// 			let string = `${c.name} ${c.alias}`;
	// 			return string.toLowerCase().includes(e.target.value.toLowerCase());
	// 		})
	// }

</script>

<svelte:head>
    <title>Location List</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
			]}
			back={route('dashboard')}
			title={layout == 'map' ? "World Map" : "Location List"}
			actions={[
				{ icon: "Plus",     theme: "accent",  href: route('locations.create') },
				{ icon: "GearFine", theme: "neutral", href: route('locations.settings') },
			]}
		>
			<Flex align="start" gap={3}>

				<!-- Search -->

				<Input type="search" bind:value={query} class="w-48"
					icon="MagnifyingGlass" name="search" placeholder="Search..."
				/>

				<!-- Filter -->

				<Dropdown class="w-48" contentClass="w-48" icon="FunnelSimple" label="All locations..." bind:value={filter} options={[
					{ label: 'Nameless',   value: 'noname' },
					{ label: 'Incomplete', value: 'incomplete' },
					{ separator: true },
					{ label: 'Has character...', children: characters.map(c => {
						return { label: c.name, value: `character.${c.slug}`, image: c.portrait?.url }
					}) },
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
								{ value: 'characters', label: "Characters" },
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
		</PageHeader>
	{/snippet}

	{#snippet article()}
		<Section class="overflow-y-auto py-12">
			{#if activeProject && locations?.length > 0}


				<!-- Table -->

				{#if layout == 'table'}
					<LocationTable
						locations={locationList}
					/>
					

				<!-- Grid -->

				{:else if layout == 'grid'}
					<LocationGrid cols={gridCols}
						locations={locationList}
						onEdit={openLocationModal}
						onDelete={deleteLocationModal}
					/>


				<!-- Map -->
				
				{:else if layout == 'map'}
					<Map
						constrain={false}
						class="bg-black/50 max-h-full rounded-lg"
						location={worldTree}
					/>


				{/if}
			{:else}
				<p class="mt-12">There are no locations for this project yet. <Link href={route('locations.create')}>Create one?</Link></p>
			{/if}
		</Section>
	{/snippet}
    
</AuthenticatedLayout>

<Modal title="Add Location" show={locationModalOpen} onclose={closeModal}>
	<NewLocationForm oncancel={closeModal} />
</Modal>