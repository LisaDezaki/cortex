<script>
	import { Flex, Stack } from '@/Components/Core'
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
		subheading,
		class: className,
		...restProps
    } = $props()
</script>

<Flex as="header" align="start" class="heading {className}" {...restProps}>

	<Stack>
		{#if eyebrow}
			<Flex align="center" gap={1} class="absolute font-style-button -mt-5 text-accent">
				{#if eyebrowIcon}
					<Icon name={eyebrowIcon} size="sm" weight="regular" />
				{/if}
				<span>{eyebrow}</span>
			</Flex>
		{/if}

		<svelte:element this={is} class="heading-head font-style-{as}">
			{heading}
			{@render children?.()}
		</svelte:element>
		
		{#if subheading}
			<div class="heading-subhead font-style-placeholder">
				{subheading}
			</div>
		{/if}
	</Stack>

	{#if actions}
		<Flex gap={3} class="ml-auto">
			{#each actions as action}
				<Button type="button" style={action.style || "hard"} {...action} />
			{/each}
		</Flex>
	{/if}

</Flex>