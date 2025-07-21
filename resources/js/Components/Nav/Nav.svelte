<script>

	import Logo from '@/Components/Logo.svelte'

    let {
		children,
        class: className,
		header,
		footer,
        ...attrs
    } = $props()

</script>

<nav class="nav {className}" {...attrs}>

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
		@apply flex flex-col items-center h-full min-w-12 w-48 max-w-64 border-r flex-shrink-0;
		background-color: var(--bg-nav);
		border-color: var(--border-nav);
		color: var(--text-nav-link);
	}

	nav ul.nav-list {
		@apply flex flex-col gap-1 w-full;

		&:not(:last-of-type) {
			@apply border-b border-emerald-950/30;
		}
		&:not(:first-of-type) {
			@apply border-t border-emerald-500/20;
		}
		&.scrollable {
			@apply overflow-y-auto;
			&::-webkit-scrollbar {
				background: transparent;
				width: 4px;
			}
			&::-webkit-scrollbar-thumb {
				background: var(--border-accent);
				/* border-radius: 2px; */
			}
		}
	}

</style>