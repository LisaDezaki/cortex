<script>
	
    import clsx from "clsx"
	import Flex from "@/Components/Core/Flex.svelte"

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
		main: clsx('main bg-surface flex-1 h-full overflow-hidden', className)
	})

</script>

<Flex as="main" class={cx.main} gap={0} {...restProps}>
	{#if children}
		{@render children()}
	{/if}
</Flex>