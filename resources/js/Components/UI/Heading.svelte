<script>
	import { Link } from '@inertiajs/svelte'
	import { Flex, Inline, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'

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
</script>

<Inline as="header" align="center" class="heading {className}" {...restProps}>

	<Flex direction="col" align="start" justify="start" gap={0}>
		{#if eyebrow}
			<Flex align="center" gap={2} class="text-neutral-soft">
				{#if eyebrowIcon}
					<Icon name={eyebrowIcon} size="sm" weight="bold" />
				{/if}
				<span class="text-medium">{eyebrow}</span>
			</Flex>
		{/if}

		<svelte:element this={is} class="heading-head whitespace-pre-wrap font-style-{as} {headingClass}">
			{heading}
			{@render children?.()}
		</svelte:element>
		
		{#if subheadingLink && subheading}
			<Link class="italic text-accent hover:underline {subheadingClass}" href={subheadingLink}>
				{subheading}
			</Link>
		{:else if subheading}
			<div class="heading-subhead italic {subheadingClass}">
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