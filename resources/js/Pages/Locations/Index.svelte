<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import NewLocationForm from '@/Forms/NewLocationForm.svelte'
	import RegionForm from '@/Forms/RegionForm.svelte'
	import LocationGrid from '@/Partials/LocationGrid.svelte'
	import LocationTable from '@/Partials/LocationTable.svelte'

	import Back from '@/Components/Back.svelte';
	import Dropdown from '@/Components/Dropdown.svelte'
	import Heading from '@/Components/Heading.svelte'
	import Icon from '@/Components/Icon.svelte'
	import Input from '@/Components/Input.svelte'
	import Modal from '@/Components/Modal.svelte'
	import RegionMap from '@/Components/RegionMap.svelte'
	import Section from '@/Components/Section.svelte'

	const activeProject = $page.props.activeProject.data
	const characters = activeProject?.characters
	const locations = activeProject?.locations
	const regions = activeProject?.regions
	const customFields  = $page.props.customFields?.data

	let columns   = $state(['name', 'characters'])
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
	let regionModalOpen         = $state(false)
	let deleteRegionModalOpen   = $state(false)

	let activeLocation    = $state(null)
	let activeRegion      = $state(null)

	let gridCols = $derived(10-rowSize)
	let hasFilter     = $derived(Boolean(filter.name && filter.value))
	let locationList = $derived(
		locations
			.filter(c => {
				if (query.length > 0 && !c.name.toLowerCase().includes(query.toLowerCase())) { return false }
				// if (hasFilter && filter.name === 'Faction' && c.factions[0]?.name !== filter.value) { return false }
				if (!['Faction', 'Location', 'Relationship'].includes(filter.name) && filter.value && c.customFieldValues?.find(f => f.field?.label === filter.name)?.value !== filter.value) { return false }
				return true
			}).sort((a, b) => {
				if (sortBy === 'name')    { return a.name > b.name                       ? 1 : -1 }
				if (sortBy === 'region')  { return a.region.name > b.region.name         ? 1 : -1 }
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
	function openRegionModal(region) {
		activeRegion = region
		regionModalOpen = true
	}
	function deleteRegionModal(region) {
		activeRegion = region
		deleteRegionModalOpen = true
	}
	function closeModal() {
        locationModalOpen = false
		deleteLocationModalOpen = false
		regionModalOpen = false
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
    <title>{activeProject?.name} Locations</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet article()}
		<Back href="/" />
		<Section class="space-y-6">
			<Heading is="h2" as="h4"
				heading="Locations"
				actions={[
					{ icon: "Plus",     theme: "accent",  onclick: openRegionModal,   label: "Add Region" },
					{ icon: "Plus",     theme: "accent",  onclick: openLocationModal, label: "Add Location" },
					{ icon: "GearFine", theme: "neutral", href: route('locations.settings') },
				]}
			/>

			<div class="flex items-start gap-3">

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
					{ label: 'In region...', children: regions.map(r => {
						return { label: r.name, value: `region.${r.slug}`, image: r.banner?.url }
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
					{ value: 'region', label: "By region name" },
					{ separator: true },
					{ value: 'created', label: "Date Created" },
					{ value: 'updated', label: "Date Updated" },
					{ value: 'random',  label: "Randomly" },
				]} />

				<!-- Result Count -->

				<div class="bg-emerald-500/10 text-emerald-500 rounded-lg p-2">{locationList.length} {locationList.length !== 1 ? 'results' : 'result'}</div>

				<!-- Size / Columns -->

				<div class="inline-flex gap-1.5 ml-auto min-w-40 flex-shrink-0">
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
				</div>

				<!-- Layout -->

				<Input type="select" class="w-32"
					bind:value={layout}
					options={[
						{ icon: "Compass",  label: "Map",   value: "map" },
						{ icon: "GridFour", label: "Grid",  value: "grid"  },
						{ icon: "Table",    label: "Table", value: "table" }
					]}
				/>

			</div>

			{#if activeProject && locations?.length > 0}
				<div class="flex flex-col gap-4">
					{#if layout == 'table'}
						<LocationTable locations={locationList} />
					{:else if layout == 'grid'}
						{#if regions.length > 0}
							<LocationGrid cols={gridCols}
								locations={locationList}
								regions={regions}
								byRegion={sortBy == 'region'}
								onEdit={openLocationModal}
								onDelete={deleteLocationModal}
							/>
						{/if}
					{:else if layout == 'map'}
						<div class="space-y-3">
							{#each regions as region}
								<Heading heading={region.name} is="h5" as="h6" />
								<RegionMap region={region} />
							{/each}
						</div>
					{/if}
				</div>
			{:else}
				<p class="mt-12">There are no locations for this project yet. <Link href={route('locations.create')}>Create one?</Link></p>
			{/if}
		</Section>
	{/snippet}
    
</AuthenticatedLayout>

<Modal title="Add Location" show={locationModalOpen} onclose={closeModal}>
	<NewLocationForm oncancel={closeModal} />
</Modal>

<Modal title="Add Region" show={regionModalOpen} onclose={closeModal}>
	<RegionForm oncancel={closeModal} />
</Modal>