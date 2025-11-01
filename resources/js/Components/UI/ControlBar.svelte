<script>

	import { Flex, Grid, Inline } from '@/Components/Core'
	import Dropdown	from '@/Components/UI/Dropdown.svelte'
	import Input	from '@/Components/UI/Input.svelte'

	let {
		class: className,
		data,

		query	= $bindable(),
		filter	= $bindable(),
		sort	= $bindable(),
		size	= $bindable(),
		layout  = $bindable(),
		results	= $bindable(),

		min = 4,
		max = 8,

		searchable 	= true,
		filterable 	= true,
		sortable	= true,
		layoutable	= true,
		resizeable  = true,

		filterOptions,
		sortOptions,
		layoutOptions,

		onUpdate = () => {},
		...restProps
	} = $props()


	function onQuery() {
		onUpdate('query', query)
	}

	function onFilter(filter) {
		onUpdate('filter', filter)
	}

	function onSort(sort) {
		onUpdate('sort', sort)
	}

</script>



<Flex cols={6} gap={3} class="bg-surface sticky top-16 pb-1.5 shrink-0 {className}">
	

	<!-- Search -->

	{#if searchable}
		<Input bind:value={query}
			type="search"
			class="w-40" size="md"
			label="Search" labelIcon="MagnifyingGlass"
			name="search"
			placeholder="Search..."
			oninput={onQuery}
		/>
	{/if}


	<!-- Filter -->

	<!-- TODO:	Dropdown component subitem selection doesn't behave as an input.
	 			Probably requires a custom component that updates the value
				even when clicking items in submenus. -->

	{#if filterable}
		<Dropdown size="md" bind:value={filter}
			class="w-40" contentClass="w-40"
			label="Filter" labelIcon="FunnelSimple"
			options={filterOptions}
			onUpdate={onFilter}
		/>
	{/if}


	<!-- Sort -->

	{#if sortable}
		<Input type="select" size="md" bind:value={sort}
			class="w-40" contentClass="w-40"
			label="Sort" labelIcon="SortAscending"
			placeholder="Sort by"
			options={sortOptions}
			onUpdate={onSort}
		/>
	{/if}


	<!-- Result Count -->

	<Flex class="w-full">
		<Inline class="bg-emerald-500/10 border-b border-accent-softest h-8 mt-auto mr-auto p-md rounded text-accent text-sm whitespace-nowrap">
			{results?.length} {results?.length !== 1 ? 'results' : 'result'}
		</Inline>
	</Flex>


	<!-- Size -->

	<Input bind:value={size}
		type="slider"
		class="w-40"
		label="Size" labelIcon="Resize"
		style="none"
		showTicks={true}
		showValue={false}
		{min} {max}
	/>


	<!-- Layout -->

	<Input type="select" size="md" bind:value={layout}
		class="w-40" contentClass="w-40"
		label="Layout" labelIcon="Layout"
		options={layoutOptions}
	/>

</Flex>