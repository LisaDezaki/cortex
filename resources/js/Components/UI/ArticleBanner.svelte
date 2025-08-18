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

<Stack items="start" justify="end" class="article-banner relative bg-neutral-softest h-56 overflow-hidden px-6 py-6 rounded-lg {className}" {...restProps}>
	{#if image}
		<Flex items="center" justify="center" class="absolute inset-0">
			<img src={image} alt={imageAlt} class="min-h-full min-w-full object-cover" />
		</Flex>
	{/if}
	<div class="relative z-10">
		{@render children?.()}
	</div>
</Stack>