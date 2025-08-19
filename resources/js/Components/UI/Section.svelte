<script>

    import Container from '@/Components/UI/Container.svelte'

	let {
        children,
		class: className,
		// size,
    } = $props()

</script>





<section class="section xl:px-12 lg:px-9 md:px-6 sm:px-3 w-full {className}">
	{@render children?.()}
</section>