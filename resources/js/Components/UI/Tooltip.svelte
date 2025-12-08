<script>

	import { Tooltip } from "bits-ui";
    import clsx from "clsx"

    let {
		children,
		class: className,
		content,
		...restProps
    } = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		tooltip: clsx(
			'border max-w-[45ch] mx-8 px-3 py-2 rounded-lg shadow-md text-sm z-50',
			'bg-emerald-500 border-emerald-600 text-white',
			className),
		trigger: clsx('tooltip-trigger flex items-center'),
	})

</script>



<Tooltip.Root>
	<Tooltip.Trigger class={cx.trigger} {...restProps}>
		{#if children}
			{@render children()}
		{/if}
	</Tooltip.Trigger>
	<Tooltip.Portal>
		<Tooltip.Content class={cx.tooltip}>
			{#if content}
				{@render content()}
			{/if}
			<Tooltip.Arrow />
		</Tooltip.Content>
	</Tooltip.Portal>
</Tooltip.Root>