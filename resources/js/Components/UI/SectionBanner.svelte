<script>

	import clsx from 'clsx'
	import { Flex, Grid, Inline, Stack } from '@/Components/Core'

	let {
		children,
		class: className,
		image,
		imageAlt,
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		banner:  clsx('section-banner relative bg-neutral-softer h-24 -mx-6 px-6 py-6 rounded-lg w-full', className),
		wrapper: clsx('absolute inset-0 overflow-hidden rounded-lg'),
		image:   clsx('min-h-full min-w-full object-cover')
	})

</script>

<Stack class={cx.banner} items="start" justify="end" {...restProps}>
	{#if image}
		<Flex class={cx.wrapper} items="center" justify="center">
			<img class={cx.image}  src={image} alt={imageAlt} />
		</Flex>
	{/if}
	{@render children?.()}
</Stack>