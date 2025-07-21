<script>
	import { Tooltip } from "bits-ui";
    let {
		children,
		class: className,
		...attrs
    } = $props()
</script>

<div class="page {className}">
	<Tooltip.Provider>
		{#if children}
			{@render children()}
		{/if}
	</Tooltip.Provider>
</div>

<style lang="postcss">
	
	.page {
		@apply h-screen flex items-stretch overflow-hidden selection:bg-emerald-500;
	}
	.page:not([class*="bg-"]) {
		background-color: var(--background);
	}
	.page:not([class*="text-"]) {
		color: var(--text-body);
	}

</style>