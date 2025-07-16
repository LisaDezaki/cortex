<script>
    let {
		active,
		children,
		class: className,
    } = $props()
</script>

<div class="highlight {className} {active ? 'active' : ''}">
	{#if children}
		{@render children()}
	{/if}
</div>

<style lang="postcss">
	.highlight {
		/* @apply h-screen w-full overflow-y-auto; */
	}

	.highlight.active {
		@apply rounded-xl;
		color: var(--text-accent);
		background: repeating-linear-gradient(
						-45deg,
						rgba(16, 185, 129, 0.15),
						rgba(16, 185, 129, 0.15) 10px,
						rgba(16, 185, 129, 0.05) 10px,
						rgba(16, 185, 129, 0.05) 20px
					);
	}
</style>