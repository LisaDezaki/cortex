<script>
	import Flex from './Flex.svelte';

	let {
		align = 'center',
		children,
		class: className,
		gap = 2
	} = $props()
</script>

<Flex 
	direction="row" 
	{align} 
	{gap} 
	class={className}
>
	{@render children?.()}
</Flex>