<script>
	let {
		children,
		class: className,
		...restProps
	} = $props()
</script>



<style lang="postcss">
	.sidebar {
		@apply bg-slate-50 flex flex-col h-full max-w-96 overflow-y-auto shadow-xl shrink-0 w-96 z-10;
	}
</style>



<aside class="sidebar {className}" {...restProps}>
	{@render children?.()}
</aside>