<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import LocationGrid from '@/Partials/LocationGrid.svelte'
	import LocationTable from '@/Partials/LocationTable.svelte'

	import Back from '@/Components/Back.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Form from '@/Components/Form.svelte'
	import HeaderButton from '@/Components/HeaderButton.svelte'
	import Heading from '@/Components/Heading.svelte'
	import Icon from '@/Components/Icon.svelte'
	import Input from '@/Components/Input.svelte'
	import RegionMap from '@/Components/RegionMap.svelte'
	import Section from '@/Components/Section.svelte'
	import SetLayout from '@/Components/SetLayout.svelte'

	const activeProject = $page.props.activeProject.data
	const locations = activeProject?.locations
	const regions = activeProject?.regions
	const customFields  = $page.props.customFields?.data

	let columns   = $state(['name', 'characters'])
	let filter    = $state({})
	let layout    = $state('grid')
	let query     = $state('')
	let rowSize   = $state(6)
	let sortBy    = $state('name')
	let sortOrder = $state('asc')

	let filteredLocations = $state(locations)
	let selectedLocations = $state([])

	let creatingLocations = $state(false)

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
				if (sortBy === 'name') { return a.name > b.name ? 1 : -1 }
			})
	)

	function createLocation() {
        creatingLocation = true
    }
	function closeModal() {
        creatingLocation = false
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
					{ label: "Settings",          icon: "GearFine", theme: "neutral", href: route('locations.settings')},
					{ label: "Create a location", icon: "Plus",     theme: "accent",  href: route('locations.create') },
				]}
			/>

			<div class="flex items-start gap-3">

				<!-- Search -->

				<Input type="search" bind:value={query} class="max-w-64"
					icon="MagnifyingGlass" name="search" placeholder="Search locations..."
				/>

				<!-- Filter -->

				<!-- <CharacterFilter bind:filter /> -->

				<!-- Sort -->

				<Input type="select" class="max-w-40" icon="SortAscending" placeholder="Sort by" bind:value={sortBy} options={[
					{ value: 'name',             label: "By location name" },
					{ value: 'region',           label: "By region name" },
					{ value: 'created-at',       label: "Date Created" },
					{ value: 'updated-at',       label: "Date Updated" },
					{ value: 'random',           label: "Randomly" },
				]} />

				<!-- Result Count -->

				<div class="bg-emerald-500/10 text-emerald-500 rounded-lg p-2">{locationList.length} {locationList.length !== 1 ? 'results' : 'result'}</div>

				<!-- Size / Columns -->

				<div class="inline-flex gap-1.5 ml-auto min-w-40 flex-shrink-0">
					{#if layout === 'grid'}
						<Icon name="Resize" size={24} />
						<Form.Slider class="" showValue={false} min={3} max={7} bind:value={rowSize} />
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

				<SetLayout bind:layout options={[
					{ icon: "Compass",  value: "map"   },
					{ icon: "GridFour", value: "grid"  },
					{ icon: "Table",    value: "table" }
				]} />

			</div>

			{#if activeProject && locations?.length > 0}
				<div class="flex flex-col gap-4">
					{#if layout == 'table'}
						<LocationTable locations={filteredLocations} bind:selected={selectedLocations} {selectionMode} />
					{:else if layout == 'grid'}
						{#if regions.length > 0}
							<LocationGrid regions={regions} cols={gridCols} />
							<!-- {#each regions as region}
								<h6 class="font-style-h6 mb-3">{region.name}</h6>
								<LocationGrid locations={region.locations} />
							{/each} -->
						{/if}
					{:else if layout == 'map'}
						<div class="space-y-6">
							{#each regions as region}
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