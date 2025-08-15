<script>
	import Flex from './Flex.svelte';

	let {
		align = 'stretch',
		children,
		class: className,
		gap = 0,
		...restProps
	} = $props()

</script>

<Flex {align} {gap}
	class={className}
	direction="col"
{...restProps}>
	{@render children?.()}
</Flex>