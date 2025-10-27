<script>

    let {
		children,
        class: className,
		header,
		footer,
        ...restProps
    } = $props()

</script>

<nav class="nav {className}" {...restProps}>

	{#if header}
		{@render header()}
	{/if}

	{#if children}
		<ul class="nav-list flex-grow py-2 scrollable mb-auto">
			{@render children()}
		</ul>
	{/if}

	{#if footer}
		<ul class="nav-list py-2">
			{@render footer()}
		</ul>
	{/if}

</nav>

<style lang="postcss">

	.nav {
		@apply flex flex-col items-center h-full min-w-12 w-56 max-w-72 border-r flex-shrink-0;
		background-color: var(--bg-nav);
		border-color: var(--border-nav);
		color: var(--text-nav-link);
	}

	nav ul.nav-list {
		@apply flex flex-col gap-1 w-full;

		&:not(:first-of-type) {
			@apply border-t;
			border-color: var(--border-neutral-softest);
		}
		&.scrollable {
			@apply overflow-y-auto;
			&::-webkit-scrollbar {
				background: transparent;
				width: 4px;
			}
			&::-webkit-scrollbar-thumb {
				background: var(--border-accent);
			}
		}
	}

</style>