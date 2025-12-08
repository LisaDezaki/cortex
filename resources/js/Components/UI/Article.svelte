<script>
	
    import clsx from "clsx"

	/**
	 * Component Props
	 * @type {Object}
	 * @property {Object} children  | Slot content
	 * @property {string} className | Additional class names
	 * @property {boolean} noscroll | Disable vertical scrolling
	 */
    let {
        children,
		class: className,
		noscroll,
		...restProps
    } = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		article: clsx({
			'article h-full relative w-full': true,
			'overflow-hidden': noscroll,
			'overflow-y-auto': !noscroll
		}, className),
		empty: clsx('font-style-placeholder text-center opacity-50')
	})

</script>



<article class={cx.article} {...restProps}>
	{#if children}
		{@render children()}
	{:else}
		<p class={cx.empty}>No content available.</p>
	{/if}
</article>