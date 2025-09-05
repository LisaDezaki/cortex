<script>

	import { Flex } from '@/Components/Core'
	import Dropdown	from '@/Components/UI/Dropdown.svelte'
	import Input	from '@/Components/UI/Input.svelte'

	let {
		data 	= $bindable(),
		query 	= $bindable(),
		filter 	= $bindable(),
		sort 	= $bindable(),
		layout 	= $bindable(),
		size 	= $bindable(),

		searchable 	= true,
		filterable 	= true,
		sortable	= true,
		layoutable	= true,
		resizeable  = true,

		filterOptions,
		sortOptions,
		layoutOptions,

		onUpdate = () => {},
		onQuery,
		onFilter,
		onSort,
		onLayout,

		children,
		class: className,
		...restProps
	} = $props()

	function applyQuery(e) {
		console.log('query', e.target.value)
		onUpdate(data.filter(x => x.name.toLowerCase().includes(e.target.value)))
	}
	function applyFilter(f) {
		console.log('filter', f)
	}
	function applySort(s) {
		console.log('sort', s)
		let sortFunction = sortOptions?.find(opt => opt.value === s)?.sortFunction
		onUpdate(data.sort(sortFunction))
	}
	function applyLayout(l) {
		console.log('layout', l)
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
			oninput={applyQuery}
		/>
	{/if}
	

	<!-- Filter -->

	{#if filterable}
		<Dropdown bind:value={filter}
			class="w-48"
			contentClass="w-48"
			icon="FunnelSimple"
			options={filterOptions}
			onValueChange={applyFilter}
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
			onValueChange={applySort}
		/>
	{/if}


	<!-- Result Count -->

	<div class="bg-emerald-500/10 text-emerald-500 whitespace-nowrap rounded-lg px-3 p-2">{data?.length} {data?.length !== 1 ? 'results' : 'result'}</div>


	<!-- Size -->

	<Input bind:value={size}
		type="slider"
		class="ml-auto max-w-36"
		style="none"
		showValue={false}
		min={4} max={12}
	/>
	

	<!-- Layout -->

	<Input bind:value={layout}
		type="select"
		class="w-36"
		options={layoutOptions}
		onValueChange={applyLayout}
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