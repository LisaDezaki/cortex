<script>
	let {
		as = 'div',
		children,
		class: className = '',
		...restProps
	} = $props()
</script>

<svelte:element
	this={as}
	class={`box ${className}`}
{...restProps}>
	{@render children?.()}
</svelte:element>