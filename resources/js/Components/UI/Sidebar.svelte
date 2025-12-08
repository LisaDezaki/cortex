<script>

	import clsx from 'clsx'

	let {
		children,
		class: className,
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		sidebar: clsx('sidebar bg-slate-50 flex flex-col h-full max-w-80 overflow-y-auto shadow-xl shrink-0 w-80 z-10', className)
	})

</script>



<aside class={cx.sidebar} {...restProps}>
	{@render children?.()}
</aside>