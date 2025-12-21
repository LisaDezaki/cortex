<script>

	import clsx from 'clsx'

    let {
		children,
        class: className,
		style,
		theme,
		text,
        ...restProps
    } = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		tag: clsx('tag inline-flex items-center justify-center min-h-2 min-w-6 px-1 rounded text-center', {
			// 'bg-accent': !restProps.plain,
			// 'bg-gradient-primary text-white': restProps.primary,
			// 'bg-emerald-500/10 text-accent': restProps.secondary,
			// 'bg-disabled text-disabled': restProps.disabled,
			'bg-accent-gradient text-white':    style === 'hard'  && theme === 'accent',
			'bg-accent-softer text-accent':     style === 'soft'  && theme === 'accent',
			'bg-transparent text-accent':	    style === 'plain' && theme === 'accent',
			'bg-neutral-gradient text-neutral': style === 'hard'  && theme === 'neutral',
			'bg-neutral-softer text-neutral':   style === 'soft'  && theme === 'neutral',
			'bg-transparent text-neutral':		style === 'plain' && theme === 'neutral',
			'bg-danger-gradient text-white':	style === 'hard'  && theme === 'danger',
			'bg-danger-softest text-danger':	style === 'soft'  && theme === 'danger',
			'bg-transparent text-danger':		style === 'plain' && theme === 'danger'
		}, className),
		
	})

</script>



<span class={cx.tag} {...restProps}>
    {#if text}
		<span>{text}</span>
	{/if}

	{#if children}
		{@render children()}
	{/if}
</span>