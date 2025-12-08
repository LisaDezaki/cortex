<script>

	import clsx from 'clsx'

    let {
		children,
        class: className,
		label,
        ...restProps
    } = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		tag: clsx('tag inline-flex items-center justify-center min-h-2 min-w-6 px-1 rounded text-center', {
			'bg-accent': !restProps.plain,
			'bg-gradient-primary text-white': restProps.primary,
			'bg-emerald-500/10 text-accent': restProps.secondary,
			'bg-disabled text-disabled': restProps.disabled
		}, className),
		
	})

</script>



<span class={cx.tag} {...restProps}>
    {#if label}
		<span>{label}</span>
	{/if}

	{#if children}
		{@render children()}
	{/if}
</span>