<script>

	import { Flex, Grid, Inline, Stack } from '@/Components/Core'
	import Button	from '@/Components/UI/Button.svelte'
	import Dropdown	from '@/Components/UI/Dropdown.svelte'
	import Input	from '@/Components/UI/Input.svelte'
	import Label	from '@/Components/UI/Inputs/Label.svelte'
    import clsx from 'clsx'

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

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		bar: clsx('control-bar mt-3 shrink-0 w-full z-10', className),
		input: clsx('w-32'),
		result: clsx('bg-emerald-500/10 border-b border-accent-softest h-8 mt-auto mr-auto p-md rounded text-accent text-sm whitespace-nowrap')
	})

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



<Flex cols={6} gap={3} class={cx.bar} {...restProps}>
	

	<!-- Search -->

	{#if searchable}
		<Input bind:value={query}
			type="search"
			class={cx.input} size="md"
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
			class={cx.input} contentClass={cx.input}
			label="Filter" labelIcon="FunnelSimple"
			options={filterOptions}
			onUpdate={onFilter}
		/>
	{/if}


	<!-- Sort -->

	{#if sortable}
		<Input type="select" size="md" bind:value={sort}
			class={cx.input} contentClass={cx.input}
			label="Sort" labelIcon="SortAscending"
			placeholder="Sort by"
			options={sortOptions}
			onUpdate={onSort}
		/>
	{/if}


	<!-- Result Count -->

	<Flex class="w-full">
		<Inline class={cx.result}>
			{results?.length} {results?.length !== 1 ? 'results' : 'result'}
		</Inline>
	</Flex>


	<!-- Size -->

	<Input bind:value={size}
		type="slider"
		class={cx.input}
		label="Size" labelIcon="Resize"
		style="none"
		showTicks={true}
		showValue={false}
		{min} {max}
	/>


	<!-- Layout -->

	<!-- <Input type="select" size="md" bind:value={layout}
		class={cx.input} contentClass={cx.input}
		label="Layout" labelIcon="Layout"
		options={layoutOptions}
	/> -->

	<Stack>
		<Label>Layout</Label>
		<Inline>
			{#each layoutOptions as option, i}
				<Button
					class="{i === 0 ? "rounded-l" : "-ml-[1px]"} {i === layoutOptions.length-1 ? "rounded-r" : ""}"
					size="sm" style="soft" theme={option.value === layout ? "accent" : "neutral"} icon={option.icon}
					onclick={() => layout = option.value}
				/>
			{/each}
		</Inline>
	</Stack>


</Flex>