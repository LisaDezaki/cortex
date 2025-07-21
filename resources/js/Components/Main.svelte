<script>
    let {
		children,
		class: className,
		...attrs
    } = $props()
</script>

<main class="main {className}">
	{#if children}
		{@render children()}
	{/if}
</main>

<style lang="postcss">
	.main {
		@apply flex items-stretch flex-1 overflow-hidden h-full;
	}
</style>