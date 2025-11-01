<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Box					from '@/Components/Core/Box.svelte'
	import Flex					from '@/Components/Core/Flex.svelte'
	import Grid					from '@/Components/Core/Grid.svelte'
	import Stack				from '@/Components/Core/Stack.svelte'
	import Empty   	  			from '@/Components/UI/Empty.svelte'
	import PageHeader 			from '@/Components/UI/PageHeader.svelte'
	import Section    			from '@/Components/UI/Section.svelte'
	import LocationCard			from '@/Components/Features/Location/LocationCard.svelte'
	import LocationControlBar 	from '@/Components/Features/Location/LocationControlBar.svelte'
	import LocationGrid			from '@/Components/Features/Location/LocationGrid.svelte'
	import LocationPanel		from '@/Components/Features/Location/LocationPanel.svelte'
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
		<Section gap={0} class="h-full overflow-hidden">

			<PageHeader class="px-16 py-3"
				title="Location List"
				tabs={[
					{ label: "List",		active: true },
					{ label: "Collections",	href: route('locations.collections') },
					{ label: "Settings",	href: route('locations.settings') },
				]}
				actions={[
					{ icon: "Plus", label: "New", theme: "accent", onclick: () => locations.create(), },
				]}
			/>


			<LocationControlBar class="px-16 pb-1.5"
				data={locations} project={activeProject}
				bind:query bind:filter bind:sort
				bind:results bind:size bind:layout
			/>

			<Flex align="start" class="px-16 pt-3 pb-6 overflow-y-auto">
				{#if activeProject && locations.items?.length > 0}


					<!-- Grid -->

					{#if layout == 'grid'}
						<LocationGrid
							cols={gridCols}
							locations={results}
						>
							{#snippet gridItem(location)}
								<LocationCard
									active={selected?.id === location.id}
									location={location}
									subtitle={getSubtitle(location)}
									onclick={() => selectLocation(location)}
									iconOptions={[
										{ icon: "Star", 		onclick: () => location.star(), iconWeight: location.starred ? 'fill' : 'regular' },
										{ icon: "Eye", 			href: location.routes.show },
										{ icon: "Textbox", 		onclick: () => location.openModal('rename') },
										{ icon: "UploadSimple", onclick: () => location.openModal('setBanner') },
										{ icon: "Trash", 		onclick: () => location.openModal('delete'), theme: "danger" },
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

			</Flex>
		</Section>
	{/snippet}
	{#snippet sidebar()}
		<LocationPanel location={selected} />
	{/snippet}
</AuthenticatedLayout>