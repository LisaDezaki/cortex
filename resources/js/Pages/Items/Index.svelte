<script>

	import { onMount } from 'svelte';
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import Flex					from '@/Components/Core/Flex.svelte'
	import Grid					from '@/Components/Core/Grid.svelte'
	import Stack				from '@/Components/Core/Stack.svelte'
	import Empty				from '@/Components/UI/Empty.svelte'
	import Entity				from '@/Components/UI/Entity.svelte'
	import PageHeader			from '@/Components/UI/PageHeader.svelte'
	import Section				from '@/Components/UI/Section.svelte'
	import ItemControlBar 		from '@/Components/Features/Item/ItemControlBar.svelte'
	import ItemPanel 			from '@/Components/Features/Item/ItemPanel.svelte'
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
		query: 		urlParams.get('q')		|| '',
		filter: 	urlParams.get('filter') || '',
		sort: 		urlParams.get('sort')	|| 'name',
		direction: 	urlParams.get('dir')	|| 'desc',
		size: 		urlParams.get('size')	|| 6,
		layout: 	urlParams.get('layout')	|| 'grid',
		selected: 	urlParams.get('selected') || ''
	})

	/**
	 * Derived grid columns calculation based on size parameter
	 * @type {number}
	 */
	let gridCols = $derived(12-parameters.size)

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
			query: 		urlParams.get('q') 		|| '',
			filter: 	urlParams.get('filter') || '',
			sort: 		urlParams.get('sort') 	|| 'name',
			direction: 	urlParams.get('dir') 	|| 'desc',
			size: 		urlParams.get('size') 	|| 6,
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
				return new Date(item.meta?.createdAt).toLocaleString() || '--'
			case 'updated_at':
				return new Date(item.meta?.updatedAt).toLocaleString() || '--'
			default:
				return item.customFieldValues.find(v => v.name === parameters.sort)?.displayValue || item.alias
		}
	}

	/**
	 * Select or deselect a item in the UI
	 * @param {ItemObject} item | An ItemObject class instance
	 * @return {void}
	 */
	function selectItem(item) {
		const url = new URL(window.location);
		url.searchParams.set('selected', item?.slug)
		parameters.selected = parameters.selected === item.slug ? null : item.slug
	}

</script>



<svelte:head>
    <title>Item List</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}

		<!-- Fixed/Sticky Header -->

		<PageHeader size="7xl" class="px-20 py-2"
			tabs={[
				{ text: "Item List",	active: true },
				{ text: "Settings",		href: route('items.settings') },
			]}
			actions={[
				{ icon: "Plus", text: "New", theme: "accent", onclick: () => items.create() },
			]}
		>
			<ItemControlBar
				data={items} project={activeProject}
				bind:query={parameters.query}
				bind:filter={parameters.filter}
				bind:sort={parameters.sort}
				bind:size={parameters.size}
				bind:layout={parameters.layout}
				bind:results
				min={4} max={8}
			/>
		</PageHeader>


		<!-- Main Body -->

		<Stack align="center" class="flex-1 overflow-y-auto px-20 pt-3 pb-12">
			{#if activeProject && items?.items.length > 0}


				<!-- Grid -->

				{#if parameters.layout === 'grid'}
					<Grid class="max-w-7xl w-full" cols={gridCols} gap={3}>
						{#if results.length > 0}
							{#each results as item}
								<Entity
									active={parameters.selected === item.slug}
									entity={item}
									layout="stack"
									size="auto"
									onclick={() => selectItem(item)}
								/>
							{/each}
						{:else}
							<Empty class="col-span-full" icon="Empty" text="No results found. Try changing your filters." />
						{/if}
					</Grid>


				<!-- Table -->

				{:else if parameters.layout === 'table'}
					<ItemTable
						class="max-w-7xl text-sm w-full"
						items={results}
					/>


				{/if}
			{:else}

				<Empty
					icon="Package"
					text="There are no items for this project yet."
					buttonLabel="Create one?"
					buttonClick={() => items.create()}
				/>

			{/if}
		</Stack>
	{/snippet}
	{#snippet sidebar()}
		<ItemPanel item={items?.items.find(i => i.slug === parameters.selected)} />
	{/snippet}
</AuthenticatedLayout>