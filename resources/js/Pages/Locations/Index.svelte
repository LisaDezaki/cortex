<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Box					from '@/Components/Core/Box.svelte'
	import Flex					from '@/Components/Core/Flex.svelte'
	import Grid					from '@/Components/Core/Grid.svelte'
	import Inline				from '@/Components/Core/Inline.svelte'
	import Stack				from '@/Components/Core/Stack.svelte'
	import Button     			from '@/Components/UI/Button.svelte'
	import Collapsible			from '@/Components/UI/Collapsible.svelte'
	import Empty   	  			from '@/Components/UI/Empty.svelte'
	import Heading				from '@/Components/UI/Heading.svelte'
	import PageHeader 			from '@/Components/UI/PageHeader.svelte'
	import Section    			from '@/Components/UI/Section.svelte'
	import Skeleton				from '@/Components/UI/Skeleton.svelte'
	import Tag					from '@/Components/UI/Tag.svelte'
	import Thumbnail			from '@/Components/UI/Thumbnail.svelte'
	import LocationCard			from '@/Components/Features/Location/LocationCard.svelte'
	import LocationControlBar 	from '@/Components/Features/Location/LocationControlBar.svelte'
	import LocationGrid			from '@/Components/Features/Location/LocationGrid.svelte'
	import LocationTable		from '@/Components/Features/Location/LocationTable.svelte'
	import LocationMap			from '@/Components/Features/Location/Map.svelte'
	

	//	Page props

	import ProjectObject 	from '@/services/ProjectObject'
	import CollectionList 	from '@/services/CollectionList'
	import LocationObject 	from '@/services/LocationObject'
	const activeProject   = $state(new ProjectObject($page.props.activeProject.data))
	const collections	  = $state(new CollectionList($page.props.collections?.data))
	const locations       = $state(activeProject?.locations)
	const worldTree		  = $state(new LocationObject($page.props.worldTree?.data))


	//	State & Derived values

	let query	 = $state('')
	let filter	 = $state('')
	let sort	 = $state('name')
	let size	 = $state(3)
	let layout   = $state('grid')
	let selected = $state(null)
	let gridCols = $derived(8-size)
	let results  = $derived(locations.items)

	function getSubtitle(location) {
		switch (sort) {
			case 'created_at':
				return new Date(location.meta?.createdAt).toLocaleString() || '--'
			case 'updated_at':
				return new Date(location.meta?.updatedAt).toLocaleString() || '--'
			default:
				return location.type
		}
	}

	function selectLocation(location) {
		selected = selected?.id === location?.id ? null : location
	}

</script>



<svelte:head>
    <title>Location List</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet article()}
		<Section gap={6} class="px-20">
			<Grid cols={4} gap={20} class="gap-20">
				<Box class="col-span-3">

					<PageHeader class="sticky top-0"
						title="Location List"
						tabs={[
							{ label: "List",		active: true },
							{ label: "Collections",	href: route('locations.collections') },
							{ label: "Settings",	href: route('locations.settings') },
						]}
						actions={[
							{ icon: "Plus", theme: "accent", onclick: () => locations.create(), },
						]}
					/>

					<LocationControlBar
						data={locations} project={activeProject}
						bind:query bind:filter bind:sort
						bind:results bind:size bind:layout
					/>

					{#if activeProject && locations.items?.length > 0}


						<!-- Grid -->

						{#if layout == 'grid'}
							<LocationGrid
								locations={results}
								class="py-3"
								cols={gridCols}
							>
								{#snippet gridItem(location)}
									<LocationCard
										active={selected?.id === location.id}
										location={location}
										subtitle={getSubtitle(location)}
										onclick={() => selectLocation(location)}
										iconOptions={[
											{ icon: "Star", 	onclick: () => location.star(), iconWeight: location.starred ? 'fill' : 'regular' },
											{ icon: "Eye", 		href: location.routes.show },
											{ icon: "Textbox", 	onclick: () => location.rename() },
											{ icon: "UploadSimple", onclick: () => location.addBanner() },
											{ icon: "Trash", 	onclick: () => location.delete(), theme: "danger" },
										]}
										options={[{
											icon: 'FolderSimple', iconWeight: 'regular',
											label: "Add to Collection",
											create: () => collections.create('locations', [location]),
											options: [ ...collections.items.map(collection => ({
												label: collection.name,
												onclick: 	collection.items.map(i => i.collectionable_id).includes(location.id) ? () => collection.removeItem(location) : () => collection.addItem(location),
												disabled:   collection.items.map(i => i.collectionable_id).includes(location.id),
												iconWeight: collection.items.map(i => i.collectionable_id).includes(location.id) ? 'fill' : 'light'
											}))]
										},{
											icon: 'TagSimple', iconWeight: 'regular',
											label: "Add Tags",
											onclick: () => location.applyTags()
										},{
											separator: true
										},{
											icon: 'Trash', iconWeight: 'regular',
											label: "Delete Location",
											onclick: () => location.delete(),
											theme: "danger"
										}]}
									/>
								{/snippet}
							</LocationGrid>


						<!-- Table -->
						
						{:else if layout == 'table'}
							<LocationTable
								locations={results}
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
							buttonClick={() => location.create()}
						/>
					{/if}

				</Box>
				<Stack class="col-span-1">
					<Stack class="sticky top-0 h-screen pt-16 pb-6">

						{#if selected}
							<Thumbnail aspect="aspect-video" src={selected.image?.url} class="mb-3 shadow-md" />

							<Stack gap={0}>
								<Flex align="start" justify="between">
									<Heading is="h3" as="h5">{selected.name}</Heading>
									<Button style="plain" theme="neutral" icon="DotsThreeOutlineVertical" iconSize="md" iconWeight="fill" class="rounded-full hover:bg-neutral-softest" />
								</Flex>
								<p class="-mt-1 mb-3 text-sm">{selected.type}</p>
							</Stack>

							<Collapsible class="font-style-small mb-6" collapsed={true}>
								{selected.description}
							</Collapsible>

							{#if selected.getMap()}
								<Thumbnail src={selected.getMap()?.url} class="mb-3" />
								<Flex wrap gap={0.5} class="mb-3">
									{#each selected.children as loc}
										<Tag plain class="bg-neutral-softest font-style-tiny py-0.5">{loc.name}</Tag>
									{/each}
								</Flex>
							{/if}

							<Button size="xl" style="hard" theme="accent" class="line-clamp-1 mt-auto"
								icon="Eye" iconWeight="fill"
								label="View {selected.name}"
								href={selected.routes.show}
							/>
						{/if}

					</Stack>
				</Stack>
			</Grid>
		</Section>
	{/snippet}
    
</AuthenticatedLayout>