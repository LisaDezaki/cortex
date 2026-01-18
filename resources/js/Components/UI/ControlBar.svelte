<script>
	import { onMount } from 'svelte'
	import { Flex, Grid, Inline, Stack } from '@/Components/Core'
	import Button	from '@/Components/UI/Button.svelte'
	import Dropdown	from '@/Components/UI/Dropdown.svelte'
	import Input	from '@/Components/UI/Input'
	import Label	from '@/Components/UI/Label.svelte'
    import clsx from 'clsx'

	let {
		class: className,
		data,

		query	= $bindable(''),
		filter	= $bindable('*'),
		sort	= $bindable('name'),
		size	= $bindable(),
		layout  = $bindable('grid'),
		results	= $bindable([]),

		searchable 	= true,
		filterable 	= true,
		sortable	= true,
		layoutable	= true,
		resizeable  = true,

		filterOptions	= [],
		sortOptions		= [],
		layoutOptions	= [],

		sizeOptions		= {
			min: null,
			max: null
		},

		...restProps
	} = $props()

	let filterOption    = $derived(findOption(filterOptions, filter) || '')
	let sortOption		= $derived(findOption(  sortOptions,   sort) || '')


	/**
	 * URL search parameters for state persistence
	 * @type {URLSearchParams}
	 */
	let urlParams = new URLSearchParams(typeof window !== 'undefined' ? window.location.search : '');


	/**
	 * Reactive state parameters for filtering, sorting, and layout
	 * @type {AppParameters}
	 */
	let parameters = $derived({
		query: 		urlParams.get('q')		|| '',
		filter: 	urlParams.get('filter') || '',
		sort: 		urlParams.get('sort')	|| 'name',
		direction: 	urlParams.get('dir')	|| 'desc',
		size: 		urlParams.get('size')	|| 5,
		layout: 	urlParams.get('layout')	|| 'grid',
		selected: 	urlParams.get('selected') || ''
	})


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
			size: 		urlParams.get('size') 	|| 5,
			layout: 	urlParams.get('layout') || 'grid',
			selected: 	urlParams.get('selected') || ''
		};
		refreshResults()
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
	 * Find Option by value
	 * @param options	| A collection of options, some of which may contain their own collections of options (recursive)
	 * @param value		| The value of the option to search for
	 * @returns {Object|null}
	 */
	function findOption(options, value) {
		if (options.find(opt => opt.value === value)) {
			return options.find(opt => opt.value === value)
		} else if (value.includes('.')) {
			let parent = options.find(opt => opt.value === value.split('.')[0])
			if (parent) {
				return findOption(parent.options, value)
			}
		}
		console.error('Failed to find an option matching the value:', value)
		return null
	}

	function onQuery() {
		refreshResults()
	}

	function onFilter(newFilter) {
		filter = newFilter.value
		refreshResults()
	}

	function onSort(newSort) {
		sort = newSort.value
		refreshResults()
	}

	function onLayout(newLayout) {
		layout = newLayout.value
	}

	function refreshResults() {
		if (!data.applyFilters) {
			console.error('The control bar cannot affect entities without an `applyFilters` method.')
		}
		results = data.applyFilters?.(query, filterOption.filterFunction, sortOption.sortFunction) || data.items
	}





	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		bar:	clsx('control-bar mt-1.5 shrink-0 w-full z-10', className),
		input:	clsx('w-32'),
		result:	clsx('bg-emerald-500/10 border-b border-accent-softest mt-auto mr-auto p-sm rounded text-accent text-sm whitespace-nowrap')
	})

</script>








<Flex align="center" cols={6} gap={1.5} class={cx.bar} {...restProps}>
	

	<!-- Search -->

	{#if searchable}
		<Stack>
			<Label icon="MagnifyingGlass" text="Search" />
			<Input.Text bind:value={query}
				class={cx.input}
				type="search"
				name="search"
				oninput={onQuery}
				placeholder="Search..."
				size="sm"
			/>
		</Stack>
	{/if}


	<!-- Filter -->

	{#if filterable && filterOptions}
		<Stack>
			<Label icon="FunnelSimple" text="Filter" />
			<Dropdown bind:value={filter}
				class={cx.input}
				options={filterOptions.map(opt => ({ ...opt,
					count: opt.filterFunction ? data.items.filter(opt.filterFunction).length : null,
					options: opt.options ? opt.options?.map(o => ({ ...o,
						count: o.filterFunction ? data.items.filter(o.filterFunction).length : null,
					})) : undefined
				}))}
				onUpdate={onFilter}
				placeholder="Filter..."
				size="sm"
			/>
		</Stack>
	{/if}


	<!-- Sort -->

	{#if sortable && sortOptions}
		<Stack>
			<Label icon="SortAscending" text="Sort" />
			<Input.Select bind:value={sort}
				class={cx.input}
				options={sortOptions}
				onUpdate={onSort}
				placeholder="Sort by..."
				size="sm"
			/>
		</Stack>
	{/if}

	<!-- Layout -->

	{#if layoutOptions}
		<Stack>
			<Label icon="Shapes" text="Layout" />
			<Input.Select bind:value={layout}
				class={cx.input}
				options={layoutOptions}
				onUpdate={onLayout}
				placeholder="As layout..."
				size="sm"
			/>
		</Stack>
	{/if}


	<!-- Result Count -->

	<Flex class="place-self-end w-full">
		<Inline class={cx.result}>
			{results?.length} {results?.length !== 1 ? 'results' : 'result'}
		</Inline>
	</Flex>


	<!-- Size -->

	{#if resizeable}
		<Stack>
			<Label icon="Resize" text="Size" />
			<Input.Slider bind:value={size}
				size="sm"
				style="none"
				showTicks={true}
				showValue={false}
				min={sizeOptions.min}
				max={sizeOptions.max}
			/>
		</Stack>
	{/if}


	<!-- Layout -->

	<!-- <Stack>
		<Label icon="Layout" text="Layout" />
		<Inline>
			{#each layoutOptions as option, i}
				<Button
					class="border-b {i === 0 ? "rounded-l" : "-ml-[1px] rounded-none"} {i === layoutOptions.length-1 ? "rounded-r" : "rounded-none"} {option.value === layout ? "bg-accent-softest border-accent-softer text-accent" : "bg-slate-50 border-neutral-softest"}"
					icon={option.icon} size="sm"
					onclick={() => layout = option.value}
				/>
			{/each}
		</Inline>
	</Stack> -->

</Flex>