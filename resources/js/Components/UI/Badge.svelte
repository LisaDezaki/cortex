<script>

	import clsx from 'clsx'

    let {
        class: className,
		text,
		style,
		theme,
        ...restProps
    } = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		badge: clsx({
			'inline-flex items-center justify-center shrink-0': true,
			'border-none min-h-2 min-w-2 rounded-full text-xs': true,
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
		text: 	clsx('text-center min-w-6 px-1 py-0.5')
	})

</script>



<span {...restProps}
	class={cx.badge}
	class:plain={restProps.plain}
	class:primary={restProps.primary}
	class:secondary={restProps.secondary}
	class:disabled={restProps.disabled}
>
    {#if text}
		<span class={cx.text}>{text}</span>
	{/if}
</span>