<script>
	import { Flex } from '@/Components/Core'
	let {
		children,
		class: className,
		...restProps
	} = $props()
</script>

<Flex direction="col" align="start" justify="start" gap={0}
	class="article-banner relative aspect-[3/1] bg-neutral-softer px-6 py-6 rounded-lg w-full {className}"
{...restProps}>
	{@render children?.()}
</Flex>