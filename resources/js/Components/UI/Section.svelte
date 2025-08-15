<script>

    import Container from '@/Components/UI/Container.svelte'

	let {
        children,
		class: className,
		size,
    } = $props()

</script>





<section class="section w-full {className}">

	{#if size}
		<Container size={size}>
			{@render children?.()}
		</Container>
	{:else}
		{@render children?.()}
	{/if}

</section>