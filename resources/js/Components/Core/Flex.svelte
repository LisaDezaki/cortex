<script>

	import Box from './Box.svelte';

	let {
		align = 'stretch',
		children,
		class: className,
		direction = 'row',
		gap = 1.5,
		justify = 'flex-start',
		wrap = false,
		...restProps
	} = $props()

</script>

<Box class="flex flex-{direction} items-{align} justify-{justify} {wrap ? 'flex-wrap' : ''} gap-{gap} {className}" {...restProps}>
	{@render children?.()}
</Box>