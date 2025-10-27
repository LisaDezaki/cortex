<script>
	import Flex from './Flex.svelte';

	let {
		align = 'center',
		children,
		class: className,
		gap = 2,
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