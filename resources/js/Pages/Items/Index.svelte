<script>

	import { onMount } from 'svelte';
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import Grid					from '@/Components/Core/Grid.svelte'
	import Stack				from '@/Components/Core/Stack.svelte'
	import ControlBar			from '@/Components/UI/ControlBar.svelte'
	import Empty				from '@/Components/UI/Empty.svelte'
	import Entity				from '@/Components/UI/Entity.svelte'
	import PageHeading			from '@/Components/UI/PageHeading.svelte'
	import ItemTable			from '@/Components/Features/Item/ItemTable.svelte'
	import ProjectObject 		from '@/services/ProjectObject'


	/**
	 * Active project instance
	 * @type {ProjectObject}
	 */
	const activeProject	  = new ProjectObject($page.props.activeProject.data)
	const items			= activeProject?.items


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
		sort: 		urlParams.get('sort')	  || 'name',
		size: 		urlParams.get('size')	  || 5,
		layout: 	urlParams.get('layout')	  || 'grid',
		selected: 	urlParams.get('selected') || ''
	})

	/**
	 * Derived grid columns calculation based on size parameter
	 * @type {number}
	 */
	let gridCols = $derived(10-parameters.size)

	/**
	 * Derived filtered/sorted results
	 * @type {Array<CharacterObject>}
	 */
	let results  = $derived(items?.items || [])


	/**
	 * Sync with URL - Update filters from URL on component mount
	 * @returns {void}
	 */
	onMount(() => {
		urlParams = new URLSearchParams(window.location.search);
		parameters = {
			sort: 		urlParams.get('sort') 	  || 'name',
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
	 * Generate subtitle text for item cards based on current sort criteria
	 * @param {ItemObject} item | A ItemObject class instance
	 * @returns {string} subtitle to display on Item Cards
	 */
	function getSubtitle(item) {
		switch (parameters.sort) {
			// case 'popularity':
			// 	return item.relationships?.items?.length + ' Relationships'
			// case 'location':
			// 	return item.location?.name || '--'
			// case 'faction':
			// 	return item.factions?.items?.[0]?.name || '--'
			case 'created_at':
				return item.meta.created.ago || '--'
			case 'updated_at':
				return item.meta.updated.ago || '--'
			default:
				if (parameters.sort?.includes('cf.')) {
					return item.customFieldValues.find(v => v.name === parameters.sort.split('.')[1])?.displayValue || '--'
				} else {
					return item.type || '--'
				}
		}
	}

	/**
	 * Select or deselect a item in the UI
	 * @param {ItemObject} item | An ItemObject class instance
	 * @return {void}
	 */
	// function selectItem(item) {
	// 	const url = new URL(window.location);
	// 	url.searchParams.set('selected', item?.slug)
	// 	parameters.selected = parameters.selected === item.slug ? null : item.slug
	// }

</script>



<svelte:head>
    <title>Item List</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Stack class="overflow-y-auto px-20 py-12">

			<PageHeading
				title="Item List"
				subtitle="Index page"
				actions={[
					{ size: "xl", icon: "GearFine", theme: "neutral", class: "group", iconClass: "group-hover:rotate-[60deg] transition-all", href: route('items.settings') },
					{ size: "xl", icon: "Plus", text: "New", theme: "accent", onclick: () => items.openModal('create') },
				]}
			/>

			<ControlBar class="py-3"
				data={items} bind:results
				bind:layout={parameters.layout} bind:sort={parameters.sort} bind:size={parameters.size}
				filterOptions={activeProject.getOptions('items', 'filter')}
				sortOptions={activeProject.getOptions('items', 'sort')}
				layoutOptions={activeProject.getOptions('items', 'layout')}
				sizeOptions={{ min: 3, max: 7 }}
				resizeable={parameters.layout === 'grid'}
			/>

			{#if activeProject && items?.items.length > 0}

				{#if parameters.layout === 'grid'}

					<!-- Grid -->

					<Grid class="py-3 w-full" cols={gridCols} gap={3}>
						{#if results.length > 0}
							{#each results as item}
								<Entity
									active={parameters.selected === item.slug}
									entity={item}
									subtitle={getSubtitle(item)}
									href={item.routes.show}
									menu={item.actions}
								/>
							{/each}
						{:else}
							<Empty class="col-span-full" icon="Empty" text="No results found. Try changing your filters." />
						{/if}
					</Grid>
					
				{:else if parameters.layout === 'table'}

					<!-- Table -->

					<ItemTable
						class="max-w-7xl text-sm w-full"
						items={results}
					/>


				{/if}
			{:else}

				<!-- Empty -->

				<Empty
					icon="Package"
					text="There are no items for this project yet."
					buttonLabel="Create one?"
					buttonClick={() => items.openModal('create')}
				/>

			{/if}
		</Stack>
	{/snippet}
</AuthenticatedLayout>