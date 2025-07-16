<script>
    let {
		children,
        class: className,
		label,
        ...attrs
    } = $props()
</script>

<span {...attrs}
	class="tag {className}"
	class:plain={attrs.plain}
	class:primary={attrs.primary}
	class:secondary={attrs.secondary}
	class:disabled={attrs.disabled}
>
    {#if label}
		<span class="label">{label}</span>
	{/if}

	{#if children}
		{@render children()}
	{/if}
</span>

<style lang="postcss">

	.tag {
		@apply inline-flex items-center justify-center min-h-2 min-w-2 px-1.5;
		@apply border-none rounded-full;
		@apply font-normal text-xs;
		&:not(.plain) {
			background: var(--bg-accent);
		}
		&.primary {
			background: var(--gradient-primary);
			color: var(--text-white);
		}
		&.secondary {
			@apply bg-emerald-500/10;
			color: var(--text-accent);
		}
		&.disabled {
			background: var(--bg-disabled);
			color: var(--text-disabled);
		}
	}

	.tag .label {
		@apply text-center min-w-6;
	}

</style>