<script>

    import clsx from 'clsx'
	import { Flex } from '@/Components/Core'

	let {
		children,
		class: className,
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		banner: clsx('relative aspect-[3/1] bg-neutral-softer px-6 py-6 rounded-lg w-full', className)
	})

</script>



<Flex
	direction="col" gap={0}
	align="start" justify="end"
	class={cx.banner}
{...restProps}>
	{@render children?.()}
</Flex>