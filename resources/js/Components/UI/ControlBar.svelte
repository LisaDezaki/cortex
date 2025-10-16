<script>

	import { Flex, Inline } from '@/Components/Core'
	import Dropdown	from '@/Components/UI/Dropdown.svelte'
	import Input	from '@/Components/UI/Input.svelte'

	let {
		data,

		query	= $bindable(),
		filter	= $bindable(),
		sort	= $bindable(),
		size	= $bindable(),
		layout  = $bindable(),
		results	= $bindable(),

		min = 4,
		max = 12,

		searchable 	= true,
		filterable 	= true,
		sortable	= true,
		layoutable	= true,
		resizeable  = true,

		filterOptions,
		sortOptions,
		layoutOptions,

		class: className,
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



<Flex align="center" justify="start" gap={3}
	class="bg-surface sticky top-20 pb-1.5 w-full z-50"
{...restProps}>


	<!-- Search -->

	{#if searchable}
		<Input bind:value={query}
			type="search"
			class="w-40" size="sm"
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
		<Dropdown bind:value={filter}
			class="w-40" size="sm"
			contentClass="w-40"
			label="Filter" labelIcon="FunnelSimple"
			options={filterOptions}
			onUpdate={onFilter}
		/>
	{/if}


	<!-- Sort -->

	{#if sortable}
		<Input bind:value={sort}
			type="select"
			class="w-40" size="sm"
			contentClass="w-40"
			label="Sort" labelIcon="SortAscending"
			placeholder="Sort by"
			options={sortOptions}
			onUpdate={onSort}
		/>
	{/if}


	<!-- Result Count -->

	<div class="bg-emerald-500/10 text-emerald-500 whitespace-nowrap p-lg rounded-lg">
		{results?.length} {results?.length !== 1 ? 'results' : 'result'}
	</div>


	<!-- Size -->

	<Input bind:value={size}
		type="slider"
		class="ml-auto max-w-40"
		label="Size" labelIcon="Resize"
		style="none"
		showTicks={true}
		showValue={false}
		{min} {max}
	/>


	<!-- Layout -->

	<Input bind:value={layout}
		type="select"
		class="w-40" size="sm"
		contentClass="w-40"
		label="Layout" labelIcon="Layout"
		options={layoutOptions}
	/>
	
</Flex>