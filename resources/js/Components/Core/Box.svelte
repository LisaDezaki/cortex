<script>

	/**
	 *	Box
	 * 
	 *	The Box component represents the most basic element of the application.
	 *	This component has a neutral layout, so you can use TailwindCSS classes
	 *	with it easily.
	 */


	//	Component Props

	let {
		as = 'div',
		children,
		class: className,
		ref = $bindable(),
		...restProps
	} = $props()

</script>

<svelte:element
	bind:this={ref}
	this={as}
	class="box {className}"
{...restProps}>
	{@render children?.()}
</svelte:element>