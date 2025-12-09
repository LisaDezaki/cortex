<script>

	import { onMount } from 'svelte';
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Flex					from '@/Components/Core/Flex.svelte'
	import Empty   	  			from '@/Components/UI/Empty.svelte'
	import PageHeader 			from '@/Components/UI/PageHeader.svelte'
	import Section    			from '@/Components/UI/Section.svelte'
	import LocationCard			from '@/Components/Features/Location/LocationCard.svelte'
	import LocationControlBar 	from '@/Components/Features/Location/LocationControlBar.svelte'
	import LocationGrid			from '@/Components/Features/Location/LocationGrid.svelte'
	import LocationPanel		from '@/Components/Features/Location/LocationPanel.svelte'
	import LocationTable		from '@/Components/Features/Location/LocationTable.svelte'
	import ProjectObject 	from '@/services/ProjectObject'
	import LocationList 	from '@/services/LocationList'
	import LocationObject 	from '@/services/LocationObject'


	/**
	 * Active project instance
	 * @type {ProjectObject}
	 */
	const activeProject   = $state(new ProjectObject($page.props.activeProject.data))
	const locations       = $state(activeProject?.locations)


	/**
	 * URL search parameters for state persistence
	 * @type {URLSearchParams}
	 */
	let urlParams = new URLSearchParams(typeof window !== 'undefined' ? window.location.search : '');


	/**
	 * Reactive application state parameters
	 * @typedef {Object} AppParameters
	 * @property {string} query - Search query string
	 * @property {string} filter - Current filter type
	 * @property {string} sort - Sort field name
	 * @property {string} direction - Sort direction ('asc' or 'desc')
	 * @property {number} size - Grid size/layout parameter
	 * @property {string} layout - Display layout ('grid' or 'table')
	 * @property {string} selected - Slug of currently selected faction
	 */

	 /**
	 * Reactive state parameters for filtering, sorting, and layout
	 * @type {AppParameters}
	 */
	let parameters = $state({
		query: 		urlParams.get('q') 		|| '',
		filter: 	urlParams.get('filter') || '',
		sort: 		urlParams.get('sort') 	|| 'name',
		direction: 	urlParams.get('dir') 	|| 'desc',
		size: 		urlParams.get('size') 	|| 3,
		layout: 	urlParams.get('layout') || 'grid',
		selected: 	urlParams.get('selected') || ''
	})

	/**
	 * Derived grid columns calculation based on size parameter
	 * @type {number}
	 */
	let gridCols = $derived(8-parameters.size)

	/**
	 * Derived filtered/sorted results
	 * @type {Array<CharacterObject>}
	 */
	let results  = $derived(locations.items)


	/**
	 * Sync with URL - Update filters from URL on component mount
	 * @returns {void}
	 */
	onMount(() => {
		urlParams = new URLSearchParams(window.location.search);
		parameters = {
			query: 		urlParams.get('q') 		|| '',
			filter: 	urlParams.get('filter') || '',
			size: 		urlParams.get('size') 	|| 3,
			sort: 		urlParams.get('sort') 	|| 'name',
			direction: 	urlParams.get('dir') 	|| 'desc',
			layout: 	urlParams.get('layout') || 'grid',
			selected: 	urlParams.get('selected') || ''
		};
	});


	/**
	 * Update URL - Sync URL params with state changes (without page reload)
	 * @returns {void}
	 */
	$effect(() => {
		const url = new URL(window.location);
		if (parameters.query)	{ url.searchParams.set('q', parameters.query); }
		else 					{ url.searchParams.delete('q'); }
		if (parameters.filter)	{ url.searchParams.set('filter', parameters.filter); }
		else					{ url.searchParams.delete('filter'); }
		url.searchParams.set('size',		parameters.size);
		url.searchParams.set('sort',		parameters.sort);
		url.searchParams.set('direction',	parameters.direction);
		url.searchParams.set('layout',		parameters.layout);
		url.searchParams.set('selected',	parameters.selected);
		window.history.replaceState({}, '', url);
	});


	/**
	 * Get Subtitle
	 * @param {LocationObject} location | A LocationObject class instance
	 * @return {string} Subtitle to display on Location Cards
	 */
	function getSubtitle(location) {
		switch (parameters.sort) {
			case 'created_at':
				return new Date(location.meta?.createdAt).toLocaleString() || '--'
			case 'updated_at':
				return new Date(location.meta?.updatedAt).toLocaleString() || '--'
			default:
				return location.type || '--'
		}
	}

	/**
	 * Select Location
	 * @param {LocationObject} location | A LocationObject class instance
	 * @return {void}
	 */
	function selectLocation(location) {
		const url = new URL(window.location);
		url.searchParams.set('selected', location?.slug)
		parameters.selected = parameters.selected === location?.slug ? null : location.slug
	}

</script>



<svelte:head>
    <title>Location List</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Section size="7xl" gap={0} class="h-full overflow-y-auto">

			<!-- Fixed/Sticky Header -->

			<PageHeader class="px-6 py-2"
				title="Location List"
				tabs={[
					{ label: "List",		active: true },
					{ label: "Settings",	href: route('locations.settings') },
				]}
				actions={[
					{ icon: "Plus", label: "New", theme: "accent", onclick: () => locations.create(), },
				]}
			>
				<LocationControlBar
					data={locations} project={activeProject}
					bind:query={parameters.query}
					bind:filter={parameters.filter}
					bind:sort={parameters.sort}
					bind:size={parameters.size}
					bind:layout={parameters.layout}
					bind:results
				/>
			</PageHeader>

			<!-- Main Body -->

			<Flex align="start" class="px-6 pt-3 pb-6">
				{#if activeProject && results.length > 0}

					<!-- Grid -->

					{#if parameters.layout == 'grid'}
						<LocationGrid
							cols={gridCols}
							locations={results}
							gap={1.5}
						>
							{#snippet gridItem(location)}
								<LocationCard
									active={parameters.selected === location.slug}
									location={location}
									subtitle={getSubtitle(location)}
									onclick={() => selectLocation(location)}
									iconOptions={[
										{ icon: "Star", 		onclick: () => location.star(), iconWeight: location.starred ? 'fill' : 'regular' },
										{ icon: "Eye", 			href: location.routes.show },
										{ icon: "Textbox", 		onclick: () => location.openModal('rename') },
										{ icon: "UploadSimple", onclick: () => location.openModal('setMedia', { type: 'banner', aspect: 'aspect-[7/3'}) },
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
					
					{:else if parameters.layout == 'table'}
						<LocationTable
							locations={results}
						/>

					
					<!-- Map -->

					{:else if parameters.layout == 'map'}
						<!-- <LocationMap
							constrain={false}
							class="bg-black/50 max-h-full rounded-lg"
							location={worldTree}
						/> -->


					{/if}
				{:else}

					<Empty
						icon="MapPin"
						containerClass="w-full"
						message="There are no locations for this project yet."
						buttonLabel="Create one?"
						buttonClick={() => location.create()}
					/>
				{/if}

			</Flex>
		</Section>
	{/snippet}
	{#snippet sidebar()}
		<LocationPanel location={locations.items.find(l => l.slug === parameters.selected)} />
	{/snippet}
</AuthenticatedLayout>