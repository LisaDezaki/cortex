<script>
	import { Flex, Grid, Stack, Tabs } from '@/Components/Core'
    import Container from '@/Components/UI/Container.svelte'

	let {
        children,
		class: className,
		direction = 'col',
		size,
    } = $props()

</script>





<Flex as="section" {direction} class="section w-full {className}">
	{#if size}
		<Container {size} {direction} class="mx-auto">
			{@render children?.()}
		</Container>
	{:else}
		{@render children?.()}
	{/if}
</Flex>