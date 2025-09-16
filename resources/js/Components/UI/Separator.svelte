<script>

	let {
		children,
		class: className,
		href,
		...restProps
	} = $props()

</script>

<div class="separator {className}" {...restProps}>
	
</div>

<style lang="postcss">

	.separator {
		@apply border;
		border-top-color:    var(--shadow-lowlight);
		border-bottom-color: var(--shadow-highlight);
		&:not([class*='w-']) {
			@apply w-full;
		}
	}

</style>