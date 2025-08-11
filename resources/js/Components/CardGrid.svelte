<script>

    let {
		card,
		children,
		cols,
		controls,
		class: className,
		empty,
		filters,
		items,
		showControls = false,
		showItemControls = false,
		...restProps
    } = $props()

	let filter  = $state(null)
	let rowSize = $state(cols || 6)

	function clearFilters() {
		filter = null
	}

</script>

{#if controls}
	<div class="flex justify-between gap-3 w-full">
		{@render controls()}
	</div>
{/if}

<ul class="card-grid grid grid-cols-{cols || 16-rowSize} {className}" {...restProps}>
	{#if items}
		{#each items as item}
			<li class="w-full">
				{@render card(item, showItemControls)}
			</li>
		{:else}
			{@render empty()}
		{/each}
	{:else if children}
		{@render children()}
	{/if}
</ul>

<style lang="postcss">
	.card-grid {
		@apply gap-2 w-full;
	}
</style>