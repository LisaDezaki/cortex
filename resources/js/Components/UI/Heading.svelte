<script>
	
	import { Link } from '@inertiajs/svelte'
	import { Flex, Inline, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'
    import clsx from 'clsx'

    let {
		is = "h2",
		as = "h5",
		actions,
		children,
		eyebrow,
		eyebrowIcon,
		heading,
		headingClass,
		subheading,
		subheadingClass,
		subheadingLink,
		class: className,
		...restProps
    } = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		heading: clsx('heading', className),
		eyebrow: clsx('eyebrow text-neutral-soft text-medium'),
		title:   clsx('heading-title whitespace-pre-wrap', `font-style-${as}`, headingClass),
		subtitle: clsx('heading-subtitle italic', {'text-accent': subheadingLink}, subheadingClass)
	})

</script>



<Inline align="center" class={cx.heading} {...restProps}>

	<Flex direction="col" align="start" justify="start" gap={0}>

		{#if eyebrow}
			<Flex align="center" gap={2} class={cx.eyebrow}>
				{#if eyebrowIcon}
					<Icon name={eyebrowIcon} size="sm" weight="bold" />
				{/if}
				<span>{eyebrow}</span>
			</Flex>
		{/if}

		<Inline>
			<svelte:element this={is} class={cx.title}>{heading}{@render children?.()}</svelte:element>
		</Inline>


		{#if subheadingLink && subheading}
			<Link class={cx.subtitle} href={subheadingLink}>
				{subheading}
			</Link>
		{:else if subheading}
			<div class={cx.subtitle}>
				{subheading}
			</div>
		{/if}
	</Flex>

	{#if actions}
		<Flex gap={3} class="ml-auto">
			{#each actions as action}
				<Button type="button" style={action.style || "hard"} {...action} />
			{/each}
		</Flex>
	{/if}

</Inline>