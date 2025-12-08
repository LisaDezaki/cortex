<script>

	import clsx from 'clsx'

	let {
		children,
		class: className,
		href,
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		banner:  clsx('separator border-b border-neutral-softest h-0', className)
	})

</script>

<div class={cx.banner} {...restProps}></div>