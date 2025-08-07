<script>

    let {
		children,
		class: className
	} = $props()

</script>

<header class="sticky-header {className}">
	{#if children}
		{@render children()}
	{/if}
</header>

<style lang="postcss">

	.sticky-header {
		/* @apply sticky top-0 left-0 right-0 flex z-10; */
		@apply border-b flex h-12;
		background-color: var(--surface);
		border-color: var(--border-neutral-softest);
	}

</style>