<script>

	import Box from './Box.svelte';

	let {
		children,
		class: className,
		cols = 1,
		gap = 1.5,
		rows = 'auto',
		...restProps
	} = $props()

</script>

<Box 
	class={`grid grid-cols-${cols} gap-${gap} ${className}`}
	style={`grid-template-rows: ${rows}`}
{...restProps}>
	{@render children?.()}
</Box>