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
		@apply border w-full;
		border-top-color:    var(--shadow-lowlight);
		border-bottom-color: var(--shadow-highlight);
	}

</style>