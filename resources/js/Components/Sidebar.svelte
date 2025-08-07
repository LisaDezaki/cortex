<script>
	let {
		children,
		class: className,
		...restProps
	} = $props()

</script>


<aside class="sidebar {className}" {...restProps}>
	{@render children?.()}
</aside>

<style lang="postcss">

	.sidebar {
		@apply overflow-y-auto p-6 h-full;
		background-color: var(--surface);
	}

</style>