<script>

    import Container from '@/Components/UI/Container.svelte'

	let {
        children,
		class: className,
		size = "full",
    } = $props()

</script>





<section class="section flex justify-center w-full {className}">
	<Container size={size}>
		{@render children?.()}
	</Container>
</section>