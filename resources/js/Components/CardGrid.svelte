<script>
    let {
		card,
		children,
		class: className,
		items,
		...attrs
    } = $props()
</script>

<ul class="card-grid {className}" {...attrs}>
	{#if items}
		{#each items as item}
			<li>
				{@render card(item)}
			</li>
		{/each}
	{/if}
</ul>

<style lang="postcss">
	.card-grid {
		@apply grid gap-2;
	}
</style>