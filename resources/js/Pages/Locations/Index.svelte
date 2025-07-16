<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import LocationTable from './Partials/LocationTable.svelte'
	import Article from '@/Components/Article.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Card from '@/Components/Card.svelte';
	import CardGrid from '@/Components/CardGrid.svelte';
	// import LocationCard from '@/Components/LocationCard.svelte';
	import Form from '@/Components/Form'
	import Modal from '@/Components/Modal.svelte'
	import RegionMap from '@/Components/RegionMap.svelte'

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

	let location_custom_fields = $derived(custom_fields.filter(f => f.entity === 'location'));

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
		<Button icon="Plus" iconSize={24} href={route('locations.create')} class="border-l w-14 hover:bg-emerald-500/10 hover:text-emerald-500" />
	{/snippet}

	<section class="grid grid-cols-5 gap-12 px-12 py-6">
		<div class="col-span-3 space-y-6">

			<Article
				title="{project.name} Locations"
				subtitle="View and manage locations for {project.name}"
				bodyclass="space-y-6"
			>
	
				<div class="flex px-6">
					<Form.Input icon="Search" name="search" placeholder="Search locations..." bind:value={query} oninput={filterLocations} />
					<Button plain iconSize={24} icon="Compass"  onclick={() => layoutType = 'map'}   class={layoutType == 'map'   ? "text-emerald-500" : ""} />
					<Button plain iconSize={24} icon="GridFour" onclick={() => layoutType = 'grid'}  class={layoutType == 'grid'  ? "text-emerald-500" : ""} />
					<Button plain iconSize={24} icon="Table"    onclick={() => layoutType = 'table'} class={layoutType == 'table' ? "text-emerald-500" : ""} />
				</div>

				{#if project && locations?.length > 0}
					<div class="flex flex-col gap-4">
						{#if layoutType == 'table'}
							<LocationTable locations={filteredLocations} bind:selected={selectedLocations} {selectionMode} />
						{:else if layoutType == 'grid'}
							{#if regions.length > 0}
								{#each regions as region}
									<div class="p-6 pt-0">
										<h6 class="font-style-h6 mb-3">{region.name}</h6>
										<CardGrid class="xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-1" items={region.locations}>
											{#snippet card(location)}
												<Card
													class="aspect-video"
													image={location.image_path}
													icon="MapPin"
													title={location.name}
													href={route('locations.show', {location: location.slug})}
												/>
											{/snippet}
										</CardGrid>
									</div>
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
			</Article>

		</div>
		<div class="col-span-2 space-y-6">

			<div class="flex gap-3">
				<Button
					secondary
					class="w-full"
					icon="Plus"
					label="Create a new region"
					href={route('locations.create')}
				/>
				<Button
					primary
					class="w-full"
					icon="Plus"
					label="Create a new location"
					href={route('locations.create')}
				/>
			</div>

			<Article
				title="Custom Fields"
				subtitle="for Locations"
				bodyclass="px-6"
			>
				<Form class="flex flex-col items-center space-y-3">
					{#if location_custom_fields.length > 0}
						{#each location_custom_fields as field}
							<Form.Field class="w-full" {...field} />	
						{/each}
					{:else}
						<span class="flex items-center h-9">You haven't created any custom fields for Locations yet.</span>
					{/if}
					<Button
						plain
						class="bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-500 rounded-lg font-style-button"
						icon="Plus"
						label="Add a custom field"
					/>
				</Form>
			</Article>

		</div>

	</section>
    
</AuthenticatedLayout>