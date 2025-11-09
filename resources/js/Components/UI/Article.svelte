<script>

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
	let cx = {
		article: "h-full relative w-full " + className,
		empty:	 "font-style-placeholder text-center opacity-50"
	}

</script>



<article class="{cx.article} {noscroll ? 'overflow-hidden' : 'overflow-y-auto'}" {...restProps}>
	{#if children}
		{@render children()}
	{:else}
		<p class={cx.empty}>No content available.</p>
	{/if}
</article>