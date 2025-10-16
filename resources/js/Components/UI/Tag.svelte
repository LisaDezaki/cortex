<script>
    let {
		children,
        class: className,
		label,
        ...restProps
    } = $props()
</script>

<span {...restProps}
	class="tag {className}"
	class:plain={restProps.plain}
	class:primary={restProps.primary}
	class:secondary={restProps.secondary}
	class:disabled={restProps.disabled}
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
		@apply inline-flex items-center justify-center min-h-2 min-w-2 px-1;
		@apply rounded-sm;
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