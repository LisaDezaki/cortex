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



<Flex align="start" gap={3}
	class="backdrop-blur-lg bg-white/50 border-b border-neutral-softest sticky top-0 px-12 py-3 w-full z-50"
{...restProps}>


	<!-- Search -->

	{#if searchable}
		<Input bind:value={query}
			type="search"
			class="w-48"
			icon="MagnifyingGlass"
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
			class="w-48"
			contentClass="w-48"
			icon="FunnelSimple"
			options={filterOptions}
			onUpdate={onFilter}
		/>
	{/if}


	<!-- Sort -->

	{#if sortable}
		<Input bind:value={sort}
			type="select"
			class="w-48"
			icon="SortAscending"
			placeholder="Sort by"
			options={sortOptions}
			onUpdate={onSort}
		/>
	{/if}


	<!-- Result Count -->

	<div class="bg-emerald-500/10 text-emerald-500 whitespace-nowrap rounded-lg px-3 p-2">
		{results?.length} {results?.length !== 1 ? 'results' : 'result'}
	</div>


	<!-- Size -->

	<Input bind:value={size}
		type="slider"
		class="ml-auto max-w-36"
		style="none"
		showValue={false}
		{min} {max}
	/>
	

	<!-- Layout -->

	<Input bind:value={layout}
		type="select"
		class="w-36"
		options={layoutOptions}
	/>

	
	

	<!-- Layout-specific Controls -->

	<!-- <Flex gap={1.5} class="min-w-40 flex-shrink-0">
		{#if layout === 'graph'}
			<Icon name="MagnifyingGlass" size="md" />
			<Input type="slider" style="none" class="" showValue={false} min={4} max={12} bind:value={rowSize} />
		{:else if layout === 'grid'}
			<Icon name="Resize" size="md" />
			<Input type="slider" style="none" class="" showValue={false} min={4} max={12} bind:value={rowSize} />
		{:else if layout === 'table'}
			<Input type="select" multiple
				class="ml-auto"
				overrideLabel="Columns..."
				bind:value={columns}
				options={[
					{ value: 'faction',       label: "Faction" },
					{ value: 'relationships', label: "Relationships" },
					{ value: 'location',      label: "Location" },
					...customFields.map((field) => {
						return { value: field.name, label: field.label }
					})
				]}
			/>
		{/if}
	</Flex> -->

	

	
</Flex>

<!-- Debug -->
 
<!-- <Flex align="center" gap={3} class="px-12">
	<Inline justify="center" class="border border-danger line-clamp-1 text-sm truncate px-3 py-1.5 rounded-full w-48">Query: "{query}"</Inline>
	<Inline justify="center" class="border border-danger line-clamp-1 text-sm truncate px-3 py-1.5 rounded-full w-48">Filter: "{filter}"</Inline>
	<Inline justify="center" class="border border-danger line-clamp-1 text-sm truncate px-3 py-1.5 rounded-full w-48">Sort: "{sort}"</Inline>
	<Inline justify="center" class="border border-danger line-clamp-1 text-sm truncate px-3 py-1.5 rounded-full w-36 ml-auto">Layout: "{layout}"</Inline>
</Flex> -->