<script>

	import { Flex, Grid, Inline, Stack } from '@/Components/Core'
	import Button	from '@/Components/UI/Button.svelte'
	import Dropdown	from '@/Components/UI/Dropdown.svelte'
	import Icon		from '@/Components/UI/Icon.svelte'
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
		bar: clsx('control-bar mt-1.5 shrink-0 w-full z-10', className),
		result: clsx('bg-emerald-500/10 border-b border-accent-softest mt-auto mr-auto p-md rounded text-accent text-sm whitespace-nowrap')
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



<Flex align="center" cols={6} gap={3} class={cx.bar} {...restProps}>
	

	<!-- Search -->

	{#if searchable}
		<Stack>
			<Label icon="MagnifyingGlass" text="Search" />
			<Input bind:value={query}
				type="search"
				name="search"
				oninput={onQuery}
				placeholder="Search..."
				size="md"
			/>
		</Stack>
	{/if}


	<!-- Filter -->

	<!-- TODO:	Dropdown component subitem selection doesn't behave as an input.
	 			Probably requires a custom component that updates the value
				even when clicking items in submenus. -->

	{#if filterable}
		<Stack>
			<Label icon="FunnelSimple" text="Filter" />
			<Dropdown
				options={filterOptions}
				onUpdate={onFilter}
				placeholder="Filter..."
				size="md"
				bind:value={filter}
			/>
		</Stack>
	{/if}


	<!-- Sort -->

	{#if sortable}
		<Stack>
			<Label icon="SortAscending" text="Sort" />
			<Input type="select"
				options={sortOptions}
				onUpdate={onSort}
				placeholder="Sort by"
				size="md"
				bind:value={sort}
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

	<Stack>
		<Label icon="Resize" text="Size" />
		<Input bind:value={size}
			type="slider"
			style="none"
			showTicks={true}
			showValue={false}
			{min} {max}
		/>
	</Stack>


	<!-- Layout -->

	<Stack>
		<Label icon="Layout" text="Layout" />
		<Inline>
			{#each layoutOptions as option, i}
				<Button
					class="{i === 0 ? "rounded-l" : "-ml-[1px] rounded-none"} {i === layoutOptions.length-1 ? "rounded-r" : "rounded-none"} bg-slate-50"
					size="md" style="soft" theme={option.value === layout ? "accent" : ""} icon={option.icon}
					onclick={() => layout = option.value}
				/>
			{/each}
		</Inline>
	</Stack>

</Flex>