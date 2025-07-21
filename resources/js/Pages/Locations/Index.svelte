<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
	import LocationTable from '@/Partials/LocationTable.svelte'
	import Back from '@/Components/Back.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Card from '@/Components/Card.svelte';
	import CardGrid from '@/Components/CardGrid.svelte';
	import Form from '@/Components/Form'
	import Heading from '@/Components/Heading.svelte'
	import RegionMap from '@/Components/RegionMap.svelte'
	import Section from '@/Components/Section.svelte'

	let project = $page.props.active_project.data
	let locations = project?.locations
	let regions = project?.regions
	let custom_fields = project?.custom_fields

	let creatingLocations = $state(false)
	let layoutType        = $state('grid')
	let selectionMode     = $state(false)
	let query             = $state('')
	let filteredLocations = $state(locations)
	let selectedLocations = $state([])

	let location_custom_fields = $derived(custom_fields.filter(f => f.customfieldable === 'location'));

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
    <title>{project.name} Locations</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project", href: "/" },
			{ title: "Locations" }
		]} />
		<Button style="plain" theme="neutral" class="border-l"
			iconSize={24} iconWeight="light" icon="GearFine"
			href={route('locations.settings')}
		/>
		<Button style="plain" theme="accent" class="border-l"
			iconSize={24} iconWeight="light" icon="Plus"
			href={route('locations.create')}
		/>
	{/snippet}

	{#snippet article()}
		<Back href="/" />

		<Section class="space-y-6">
			<Heading is="h2" as="h4"
				heading="{project.name} Locations"
				subheading="Manage your locations here."
			/>
		
			<div class="flex">
				<Form.Input icon="Search" name="search" placeholder="Search locations..." bind:value={query} oninput={filterLocations} />
				<Button style="plain" theme="neutral" iconSize={24} icon="Compass"  onclick={() => layoutType = 'map'}   class={layoutType == 'map'   ? "text-emerald-500" : ""} />
				<Button style="plain" theme="neutral" iconSize={24} icon="GridFour" onclick={() => layoutType = 'grid'}  class={layoutType == 'grid'  ? "text-emerald-500" : ""} />
				<Button style="plain" theme="neutral" iconSize={24} icon="Table"    onclick={() => layoutType = 'table'} class={layoutType == 'table' ? "text-emerald-500" : ""} />
			</div>

			{#if project && locations?.length > 0}
				<div class="flex flex-col gap-4">
					{#if layoutType == 'table'}
						<LocationTable locations={filteredLocations} bind:selected={selectedLocations} {selectionMode} />
					{:else if layoutType == 'grid'}
						{#if regions.length > 0}
							{#each regions as region}
								<h6 class="font-style-h6 mb-3">{region.name}</h6>
								<CardGrid class="xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-1" items={region.locations}>
									{#snippet card(location)}
										<Card
											class="aspect-video"
											image={location.banner_path}
											icon="MapPin"
											title={location.name}
											href={route('locations.show', {location: location.slug})}
										/>
									{/snippet}
								</CardGrid>
							{/each}
						{/if}
					{:else if layoutType == 'map'}
						<div class="px-8 pb-8 space-y-8">
							{#each regions as region}
								<RegionMap region={region} />
							{/each}
						</div>
					{/if}
				</div>
	
			{/if}
		</Section>
	{/snippet}

	{#snippet sidebar()}
		<CustomFieldsPanel />
	{/snippet}
    
</AuthenticatedLayout>