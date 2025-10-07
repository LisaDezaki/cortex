<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Grid   	  from '@/Components/Core/Grid.svelte'
	import Button     from '@/Components/UI/Button.svelte'
	import Empty   	  from '@/Components/UI/Empty.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import Section    from '@/Components/UI/Section.svelte'
	import Separator  from '@/Components/UI/Separator.svelte'
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
	let size	 = $state(5)
	let layout   = $state('grid')
	let gridCols = $derived(10-size)
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
				{ icon: "Plus", label: "Create Location", theme: "accent", onclick: () => locations.create(), },
			]}
		/>
	{/snippet}

	{#snippet article()}

		{#if activeProject}
			<LocationControlBar
				data={locations} project={activeProject}
				bind:query bind:filter bind:sort
				bind:results bind:size bind:layout
			/>
		{/if}

		<Section gap={6} class="px-20 py-6">
			{#if activeProject && locations.items?.length > 0}


				<!-- Grid -->

				{#if layout == 'grid'}
				
					<!-- <Grid cols={4} gap={12} class="mt-6">
						<LocationCard
							class="col-span-1"
							location={worldTree}
							href={worldTree.routes.show}
						/>
						<LocationGrid
							class="col-span-3"
							cols={5}
						>
							{#each worldTree.descendants as loc}
								<LocationCard
									location={loc}
								/>
							{/each}
							<Button style="soft" theme="accent" 
								icon="Plus" class="aspect-video rounded-lg"
							/>
						</LocationGrid>
					</Grid>
					
					{#each worldTree.descendants as loc, i}
						<Separator class="ml-auto my-6 w-3/4" />
						<Grid cols={4} gap={12}>
							<LocationCard
								class="col-span-1"
								location={worldTree.descendants[i]}
								href={loc.routes.show}
							/>
							<LocationGrid
								class="col-span-3"
								cols={5}
							>
								{#each worldTree.descendants[i].descendants as loc2}
									<LocationCard
										location={loc2}
									/>
								{/each}
								<Button style="soft" theme="accent"
									icon="Plus" class="aspect-video rounded-lg"
								/>
							</LocationGrid>
						</Grid>
					{/each} -->

					<LocationGrid
						locations={results}
						cols={gridCols}
					>
						{#snippet gridItem(location)}
							<LocationCard starrable
								location={location}
								subtitle={getSubtitle(location)}
								href={location.routes.show}
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
		</Section>
	{/snippet}
    
</AuthenticatedLayout>