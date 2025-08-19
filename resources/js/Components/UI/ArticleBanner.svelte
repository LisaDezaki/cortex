<script>

	let {
		children,
		class: className,
		image,
		imageAlt,
		...restProps
	} = $props()

	import { Flex, Grid, Inline, Stack } from '@/Components/Core'

</script>

<Stack items="start" justify="end" class="article-banner relative bg-neutral-softer h-56 -mx-6 px-6 py-6 rounded-lg w-full {className}" {...restProps}>
	{#if image}
		<Flex items="center" justify="center" class="absolute inset-0 overflow-hidden rounded-lg">
			<img src={image} alt={imageAlt} class="min-h-full min-w-full object-cover" />
		</Flex>
	{/if}
	{@render children?.()}
</Stack>