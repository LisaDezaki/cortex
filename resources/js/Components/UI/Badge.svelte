<script>

	import clsx from 'clsx'

    let {
        class: className,
		label,
        ...restProps
    } = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		badge: 	clsx({
			'border-none inline-flex items-center justify-center min-h-2 min-w-2 shrink-0 font-normal text-xs': true,
			'bg-accent rounded-full': !restProps.plain,
			'bg-accent-gradient text-white': restProps.primary,
			'bg-accent-softer text-accent': restProps.secondary,
			'bg-neutral-softer text-neutral-softer': restProps.disabled
		}, className),
		label: 	clsx('text-center min-w-6 px-1 py-0.5')
	})

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