<script>

	import Box     from '@/Components/Core/Box.svelte'

	let {
        children,
		class: className,
		size = '5xl',
		...restProps
    } = $props()

	const sizes = "max-w-2xl max-w-3xl max-w-4xl max-w-5xl max-w-6xl max-w-7xl max-w-8xl max-w-9xl"

</script>





<Box class="container max-w-{size} mx-auto w-full {className}" {...restProps}>
	{@render children?.()}
</Box>