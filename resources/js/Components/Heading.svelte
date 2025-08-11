<script>
	import Button from '@/Components/Button.svelte'
	import Icon from '@/Components/Icon.svelte'

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

<header class="heading {className}" {...restProps}>

	<div>
		{#if eyebrow}
			<div class="heading-eyebrow font-style-button">
				{#if eyebrowIcon}
					<Icon name={eyebrowIcon} size="sm" weight="regular" />
				{/if}
				<span>{eyebrow}</span>
			</div>
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
	</div>

	{#if actions}
		<div class="flex gap-3 ml-auto">
			{#each actions as action}
				<Button type="button" style={action.style || "hard"} {...action} />
			{/each}
		</div>
	{/if}

</header>

<style lang="postcss">

	.heading {
		@apply flex items-start;

		.heading-eyebrow {
			@apply absolute flex items-center gap-1 -mt-5;
			color: var(--text-accent);
		}
		
		.heading-head {
		}
		
		.heading-subhead {
		}
	}
</style>