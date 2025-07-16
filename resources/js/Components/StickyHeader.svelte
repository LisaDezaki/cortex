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
		@apply flex h-12;
		background-color: var(--surface);
		box-shadow: inset 0 1px 0 var(--shadow-highlight), inset 0 -1px 0 var(--shadow-lowlight);
	}

</style>