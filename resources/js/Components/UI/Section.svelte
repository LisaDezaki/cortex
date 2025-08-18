<script>

    import Container from '@/Components/UI/Container.svelte'

	let {
        children,
		class: className,
		// size,
    } = $props()

</script>





<section class="section xl:px-12 lg:px-9 md:px-6 sm:px-3 w-full {className}">
	<div class="xl:max-w-7xl lg:max-w-4xl md:max-w-4xl sm:max-w-2xl mx-auto w-full">
		{@render children?.()}
	</div>
</section>