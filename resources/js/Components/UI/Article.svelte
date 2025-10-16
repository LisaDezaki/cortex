<script>
    let {
        children,
		class: className,
		noscroll,
		...restProps
    } = $props()

</script>

<article class="h-full relative w-full {noscroll ? 'overflow-hidden' : 'overflow-y-auto'} {className}" {...restProps}>
	{#if children}
		{@render children()}
	{:else}
		<p class="font-style-placeholder text-center opacity-50">No content available.</p>
	{/if}
</article>