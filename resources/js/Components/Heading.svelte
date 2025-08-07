<script>
	import Button from '@/Components/Button.svelte'

    let {
		is = "h2",
		as = "h5",
		actions,
		children,
		heading,
		subheading,
		class: className,
		...restProps
    } = $props()
</script>

<header class="heading {className}" {...restProps}>

	<div>
		<svelte:element this={is} class="heading-head font-style-{as}">
			{heading}
			{@render children?.()}
		</svelte:element>
		
		{#if subheading}
			<div class="heading-subhead">
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
		
		.heading-head {
		}
		
		.heading-subhead {
		}
	}
</style>