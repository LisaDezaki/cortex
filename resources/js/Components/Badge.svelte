<script>
    let {
        class: className,
		label,
        ...restProps
    } = $props()
</script>

<span {...restProps}
	class="badge {className}"
	class:plain={restProps.plain}
	class:primary={restProps.primary}
	class:secondary={restProps.secondary}
	class:disabled={restProps.disabled}
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
			background-color: var(--bg-accent);
			@apply rounded-full;
		}
		&.primary {
			background: var(--bg-accent-gradient);
			color: var(--text-white);
		}
		&.secondary {
			background-color: var(--bg-accent-softer);
			color: var(--text-accent);
		}
		&.disabled {
			background-color: var(--bg-neutral-softer);
			color: var(--text-neutral-softer);
		}
	}

	.badge .label {
		@apply text-center min-w-6 px-1 py-0.5;
	}

</style>