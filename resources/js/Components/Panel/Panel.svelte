<script>

	import Item from './Item.svelte'
	import Form from '@/Components/Form'

    let {
		children,
		class: className,
		items,
        onsubmit,
        ...attrs
    } = $props()

	let query = $state('')
	let filteredItems = $state(items)

	function filterItems(e) {
		filteredItems = query.length == 0
			? items
			: items.filter(item => {
				return item.label.toLowerCase().includes(e.target.value.toLowerCase());
			})
	}

</script>

<div class="panel {className}" {...attrs}>

	{#if attrs.searchable}
		<div class="border-b border-slate-500/10 flex-shrink-0">
			<Form.Input
				plain
				class="bg-transparent border-none rounded-none"
				placeholder="Search"
				oninput={filterItems}
				bind:value={query}
			/>
		</div>
	{/if}

	<ul class="panel-list border-t border-white">
		{#if children}
			{@render children()}
		{/if}
		{#if filteredItems}
			{#each filteredItems as item}
				<Item
					showImage
					{...item}
				/>
			{/each}
		{/if}
	</ul>

</div>

<style lang="postcss">

	.panel {
		@apply flex flex-col w-60 shadow-lg;
		/* @apply overflow-hidden; */
		background-color: var(--surface);
		box-shadow: inset  1px  1px  0 var(--shadow-highlight),
					inset -1px -1px  0 var(--shadow-lowlight);
	}
	
	.panel-list {
		@apply py-2 overflow-y-auto;
		&::-webkit-scrollbar {
			background: transparent;
			width: 4px;
		}
		&::-webkit-scrollbar-thumb {
			background: var(--border-soft);
			border-radius: 2px;
		}
	}

</style>