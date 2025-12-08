<script>
	import Flex from './Flex.svelte';

	let {
		align = 'center',
		children,
		class: className,
		gap = 0,
		...restProps
	} = $props()
</script>

<Flex 
	direction="row" 
	{align} 
	{gap} 
	class={className}
{...restProps}>
	{@render children?.()}
</Flex>