<script>
    let {
		children,
		class: className,
		...restProps
    } = $props()
</script>

<main class="main {className}" {...restProps}>
	{#if children}
		{@render children()}
	{/if}
</main>

<style lang="postcss">
	.main {
		@apply flex items-stretch flex-1 overflow-hidden h-full;
		background-color: var(--surface);
	}
</style>