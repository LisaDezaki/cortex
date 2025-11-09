<script>

    let {
        class: className,
		label,
        ...restProps
    } = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = {
		badge: "border-none inline-flex items-center justify-center min-h-2 min-w-2 font-normal text-xs" + className,
		primary: "bg-accent-gradient text-white",
		secondary: "bg-accent-softer text-accent",
		disabled:	"bg-neutral-softer text-neutral-softer",
		label: "text-center min-w-6 px-1 py-0.5"
	}

</script>



<span {...restProps}
	class={cx.badge}
	class:plain={restProps.plain}
	class:primary={restProps.primary}
	class:secondary={restProps.secondary}
	class:disabled={restProps.disabled}
>
    {#if label}
		<span class={cx.label}>{label}</span>
	{/if}
</span>

<style lang="postcss">

	.badge {

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

</style>