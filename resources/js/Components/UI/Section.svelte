<script>
	import clsx from 'clsx'
	import { Flex, Grid, Stack, Tabs } from '@/Components/Core'
    import Container from '@/Components/UI/Container.svelte'

	let {
        children,
		class: className,
		direction = 'col',
		size,
		...restProps
    } = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		section: clsx('section w-full', className),
	})

</script>



<Flex as="section" {direction} class={cx.section} {...restProps}>
	{#if size}
		<Container {size} {direction} class="max-h-full mx-auto">
			{@render children?.()}
		</Container>
	{:else}
		{@render children?.()}
	{/if}
</Flex>