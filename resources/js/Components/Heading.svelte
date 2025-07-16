<script>
    let {
		is = "h2",
		as = "h5",
		children,
		heading,
		subheading,
		class: className,
		...attrs
    } = $props()
</script>

<header class="heading {className}">

	<svelte:element this={is} class="heading-head font-style-{as}">
		{heading}
		{@render children?.()}
	</svelte:element>
	
	{#if subheading}
		<div class="heading-subhead">
			{subheading}
		</div>
	{/if}
</header>

<style lang="postcss">

	/* .font-style-h1 { margin-bottom: 1.5rem; }
	.font-style-h2 { margin-bottom: 1rem; }
	.font-style-h3 { margin-bottom: 0.875rem; }
	.font-style-h4 { margin-bottom: 0.75rem; }
	.font-style-h5 { margin-bottom: 0.625rem; }
	.font-style-h6 { margin-bottom: 0.5rem; } */

	.heading {
		
		.heading-head {
		}
		
		.heading-subhead {
		}
	}
</style>