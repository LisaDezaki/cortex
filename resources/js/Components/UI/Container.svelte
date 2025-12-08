<script>
	import Stack     from '@/Components/Core/Stack.svelte'
    import clsx from 'clsx'

	let {
        children,
		class: className,
		size = 'none',
		...restProps
    } = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		container: clsx({
			'container w-full': true,
			'max-w-2xl': size === '2xl',
			'max-w-3xl': size === '3xl',
			'max-w-4xl': size === '4xl',
			'max-w-5xl': size === '5xl',
			'max-w-6xl': size === '6xl',
			'max-w-7xl': size === '7xl',
			'max-w-8xl': size === '8xl',
			'max-w-9xl': size === '9xl',
		}, className)
	})

</script>



<Stack class={cx.container} {...restProps}>
	{@render children?.()}
</Stack>