<script>
    let {
        class: className,
		label,
        ...attrs
    } = $props()
</script>

<span {...attrs}
	class="badge {className}"
	class:plain={attrs.plain}
	class:primary={attrs.primary}
	class:secondary={attrs.secondary}
	class:disabled={attrs.disabled}
>
    {#if label}
		<span class="label">{label}</span>
	{/if}
</span>

<style lang="postcss">

	.badge {
		@apply inline-flex items-center justify-center min-h-2 min-w-2;
		@apply border-none;
		@apply font-normal text-xs;
		&:not(.plain) {
			background: var(--bg-accent);
			@apply rounded-full;
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

	.badge .label {
		@apply text-center min-w-6 px-1 py-0.5;
	}

</style>