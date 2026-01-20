<script>

	import { onMount } from 'svelte';
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Grid				from '@/Components/Core/Grid.svelte'
	import Stack			from '@/Components/Core/Stack.svelte'
	import ControlBar   	from '@/Components/UI/ControlBar.svelte'
	import Empty   	  		from '@/Components/UI/Empty.svelte'
	import Entity			from '@/Components/UI/Entity.svelte'
	import PageHeading 		from '@/Components/UI/PageHeading.svelte'
	import LocationTable	from '@/Components/Features/Location/LocationTable.svelte'
	import ProjectObject 	from '@/services/ProjectObject'


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
		sort:		urlParams.get('sort')	  || 'name',
		size: 		urlParams.get('size') 	  || 5,
		layout: 	urlParams.get('layout')   || 'grid',
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
			sort:		urlParams.get('sort')	  || 'name',
			size: 		urlParams.get('size') 	  || 5,
			layout: 	urlParams.get('layout')   || 'grid',
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
				return location.meta.created.ago || '--'
			case 'updated_at':
				return location.meta.updated.ago || '--'
			default:
				if (parameters.sort?.includes('cf.')) {
					return location.customFieldValues.find(v => v.name === parameters.sort.split('.')[1])?.displayValue || '--'
				} else {
					return location.type || '--'
				}
		}
	}

	/**
	 * Select Location
	 * @param {LocationObject} location | A LocationObject class instance
	 * @return {void}
	 */
	// function selectLocation(location) {
	// 	const url = new URL(window.location);
	// 	url.searchParams.set('selected', location?.slug)
	// 	parameters.selected = parameters.selected === location?.slug ? null : location.slug
	// }

</script>



<svelte:head>
    <title>Location List</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Stack class="overflow-y-auto px-20 py-12">

			<PageHeading
				title="Locations List"
				subtitle="Index page"
				actions={[
					{ size: "xl", icon: "GearFine", theme: "neutral", class: "group", iconClass: "group-hover:rotate-[60deg] transition-all", href: route('locations.settings') },
					{ size: "xl", icon: "Plus", text: "New", theme: "accent", onclick: () => locations.openModal('create') },
				]}
			/>

			<ControlBar class="py-3"
				data={locations} bind:results
				bind:layout={parameters.layout}  bind:sort={parameters.sort} bind:size={parameters.size}
				filterOptions={activeProject.getOptions('locations', 'filter')}
				sortOptions={activeProject.getOptions('locations', 'sort')}
				layoutOptions={activeProject.getOptions('locations', 'layout')}
				sizeOptions={{ min: 3, max: 7 }}
				resizeable={parameters.layout === 'grid'}
			/>

			{#if activeProject && locations.items.length > 0}

				{#if parameters.layout === 'grid'}

					<!-- Grid -->

					<Grid class="py-3 w-full" cols={gridCols} gap={3}>
						{#if results.length > 0}
							{#each results as location}
								<Entity
									aspect="aspect-video"
									active={parameters.selected === location.slug}
									entity={location}
									subtitle={getSubtitle(location)}
									href={location.routes.show}
									menu={location.actions}
								/>
							{/each}
						{:else}
							<Empty class="col-span-full" icon="Empty" text="No results found. Try changing your filters." />
						{/if}
					</Grid>

				{:else if parameters.layout == 'table'}

					<!-- Table -->
				
					<LocationTable
						class="max-w-7xl text-sm w-full"
						locations={results}
					/>
				
				{:else if parameters.layout == 'map'}

					<!-- Map -->

					<Empty class="h-96 max-w-7xl w-full"
						icon="Compass" text="This layout type isn't working yet. Try again later."
					/>

				{/if}
			{:else}

				<Empty
					icon="MapPin"
					text="There are no locations for this project yet."
					buttonLabel="Create one?"
					buttonClick={() => locations.openModal('create')}
				/>
			{/if}

		</Stack>
	{/snippet}
</AuthenticatedLayout>