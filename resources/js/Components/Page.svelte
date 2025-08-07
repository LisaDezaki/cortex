<script>
	import { Tooltip } from "bits-ui";
    let {
		children,
		class: className,
		...restProps
    } = $props()
</script>

<div class="page {className}" {...restProps}>
	<Tooltip.Provider>
		{#if children}
			{@render children()}
		{/if}
	</Tooltip.Provider>
</div>

<style lang="postcss">
	
	.page {
		font-family: 'Archivo', 'Figtree';
		@apply h-screen flex items-stretch overflow-hidden selection:bg-emerald-500;
	}
	.page:not([class*="bg-"]) {
		background-color: var(--background);
	}
	.page:not([class*="text-"]) {
		color: var(--text-neutral);
	}

</style>