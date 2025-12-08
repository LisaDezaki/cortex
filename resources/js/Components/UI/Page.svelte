<script>

    import clsx from "clsx"
	import { Tooltip } from "bits-ui"
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
		page: clsx({
			'page font-body h-screen overflow-hidden selection:bg-emerald-500 selection:text-white': true,
			'bg-background': !className?.includes('bg-'),
			'text-neutral': !className?.includes('text-')
		}, className)
	})

</script>

<Flex class={cx.page} {...restProps}>
	<Tooltip.Provider>
		{#if children}
			{@render children()}
		{/if}
	</Tooltip.Provider>
</Flex>