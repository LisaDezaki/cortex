<script>

	let {
		children,
		class: className,
		...attrs
	} = $props()

</script>

<aside class="sidebar {className}" {...attrs}>
	{@render children?.()}
</aside>

<style lang="postcss">

	.sidebar {
		@apply h-full overflow-y-auto p-6 w-[38.2%];
		background-color: var(--surface);
		border-color: var(--border-soft);
		box-shadow: inset  1px  1px  0 var(--shadow-highlight),
					inset -1px -1px  0 var(--shadow-lowlight);
	}

</style>