<script>
	import { Link } from '@inertiajs/svelte'
	import Icon from '@/Components/Icon.svelte'
	import Input from '@/Components/Input.svelte'
	import Thumbnail from '@/Components/Thumbnail.svelte'

    let {
		children,
		class: className,
		items,
        onsubmit,
        ...restProps
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






{#snippet panelItem(item)}
	<li class="panel-item">
		<Link class="panel-link" active={item.active} href={item.href} preserveScroll>
			
			<Thumbnail class="h-8" src={item.image} alt={item.label} icon={item.icon} />

			<div class="flex-shrink truncate">
				{#if item.label}
					{item.label}
				{/if}
			</div>

			<!-- {#if item.active}
				<Icon class="flex-shrink-0 ml-auto" name="ArrowRight" size="sm" />
			{/if} -->

		</Link>
	</li>
{/snippet}

<div class="panel {className}" {...restProps}>

	{#if restProps.searchable}
		<div class="flex-shrink-0 px-1.5">
			<Input type="search"
				class="panel-search"
				icon="MagnifyingGlass"
				placeholder="Search"
				oninput={filterItems}
				bind:value={query}
			/>
		</div>
	{/if}

	<ul class="panel-list">
		{#if children}
			{@render children()}
		{/if}
		{#if filteredItems}
			{#each filteredItems as item}
				{@render panelItem(item)}
				<!-- <Item
					showImage
					{...item}
				/> -->
			{/each}
		{/if}
	</ul>

</div>

<style lang="postcss">

	.panel {
		@apply flex flex-col gap-1.5 h-full min-w-12 w-52 max-w-64 shadow-lg border-r py-1.5;
		background-color: var(--surface);
		border-color: var(--border-neutral-softest);

		:global(.panel-search) {
			background-color: var(--bg-neutral-softest);
			box-shadow: none;
		}
	}
	
	:global(.panel-list) {
		@apply overflow-y-auto;
		&::-webkit-scrollbar {
			background: transparent;
			width: 4px;
		}
		&::-webkit-scrollbar-thumb {
			background: var(--border-neutral-softest);
			border-radius: 2px;
		}

		:global(.panel-item) {
			@apply list-none text-sm;

			:global(.panel-link) {
				@apply flex items-center justify-start gap-2 p-1 px-2 min-h-8 w-full truncate;
				&[active="true"] {
					color: var(--text-accent);
					background-color: var(--bg-accent-softest);
				}
				&:not([active="true"]):hover {
					background-color: var(--bg-neutral-softest);
				}
			}
		}
	}

</style>