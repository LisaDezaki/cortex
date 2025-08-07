<!-- <script>
    import { page } from '@inertiajs/svelte'

	import Button from '@/Components/Button.svelte'
    import Dropdown from '@/Components/Dropdown'

	let customFields  = $page.props.customFields.data
	let characterList = $page.props.activeProject.data.characters
	let factionList   = $page.props.activeProject.data.factions
	let locationList  = $page.props.activeProject.data.locations

	let {
		filter = $bindable(),
	} = $props()

	let filterObject = $state({})
	let filterValue  = $state()
	let isOpen 		 = $state()
	let query  		 = $state('')

	let filterData            = $derived([
		{ name: "faction",      label: "In Faction...",        subItems: locationList.map(mapToFilterItem)   },
		{ name: 'location',     label: "In Location...",       subItems: factionList.map(mapToFilterItem)  },
		{ name: 'relationship', label: "Relationship with...", subItems: characterList.map(mapToFilterItem) },
		...customFields.filter(f => f.type == 'select').map(f => {
			return { name: f.name, label: f.label+'...', subItems: f.options.map(mapToFilterItem)}
		})
	])

	function clearFilterValue(e) {
		e.preventDefault()
		filter = {}
		filterObject = {}
	}

	function mapToFilterItem(item) {
		return { value: (item.slug || item.value), label: (item.label || item.name) }
	}

	function setFilter(filterObj) {
		filterObject = filterObj
		console.log(filterObject.subItems)
	}

	function setFilterValue(value) {
		filterValue = value
	}

</script>





<Dropdown class="flex items-center gap-2 w-52" placeholder={"Clear Filters"} bind:open={isOpen}>

	{#snippet trigger()}
		<div class="filter-trigger input" class:focus={isOpen}>
			{#if filter.value}
				<Button class="input-icon justify-center h-7 w-7" icon="FunnelSimpleX" iconSize={20} onclick={clearFilterValue} theme="danger" />
			{:else}
				<Button class="input-icon justify-center h-7 w-7" icon="FunnelSimple" iconSize={20} />
			{/if}
			<span class="line-clamp-1">{filter.value || "All Characters"}</span>
			{#if !filter.value}
				<Button icon="CaretUpDown" iconSize={16} class="input-action ml-auto" />
			{:else}
				<Button icon="X" iconSize={16} class="input-action ml-auto" onclick={clearFilterValue} />
			{/if}
		</div>
	{/snippet}

	{#snippet content()}
		<div class="input-content flex flex-col flex-1 overflow-hidden h-full w-52">

			{#if !filterObject?.name}
				<div class="py-2">
					{#each filterData as filterOption}
						<button class="input-option filter-name" data-name={filterOption.name} onclick={() => setFilter(filterOption)}>{filterOption.label}</button>
					{/each}
				</div>
			{:else if filterObject.name}
				<div class="flex items-center gap-1.5 flex-0 pt-1 px-1">
					<Button class="filter-clear" data-name={filter.name} icon="CaretLeft" onclick={clearFilterValue} />
					<span class="font-bold">{filterObject.label}</span>
				</div>
				<div class="flex-0 px-2 py-1">
					<input bind:value={query} class="filter-search" placeholder="Filter {filterObject.name}" />
				</div>
				<ul class="flex-1 overflow-y-auto pb-2">
					{#each filterObject.subItems.filter(c => c.label?.toLowerCase().includes(query?.toLowerCase())) as item}
						<button class="input-option filter-value" data-name={item.name} data-value={item.name} onclick={() => setFilterValue(item)}>{item.label}</button>
					{/each}
				</ul>
			{/if}
			</div>
	{/snippet}
</Dropdown>





<style class="postcss">

	:global(.filter-trigger) {
		@apply flex items-center gap-1 h-10 p-1 rounded-md text-left w-full;
	}

	:global(.filter-search) {
		@apply border-none h-8 outline-none rounded-full w-full;
		background-color: var(--bg-neutral-softest);
		&::placeholder {
			color: var(--text-neutral-softer);
			font-style: italic;
			opacity: 75%;
		}
		/* border: none!important;
		box-shadow: none!important;
		outline: none!important;
		padding: 0!important;
		height: auto!important; */
	}

	.filter-name,
	.filter-value {
		@apply block line-clamp-1 px-2.5 py-1 rounded-none text-left truncate w-full;
		border: none;
		box-shadow: none;
		outline: none;
		&:hover {
			background-color: var(--bg-neutral-softest);
		}
	}

	:global(.filter-clear) {
		@apply items-center justify-center h-7 w-7;
	}

</style> -->