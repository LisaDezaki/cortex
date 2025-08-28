<script>
	import Stack     from '@/Components/Core/Stack.svelte'

	let {
        children,
		class: className,
		size = 'none',
		...restProps
    } = $props()

	const sizes = "max-w-2xl max-w-3xl max-w-4xl max-w-5xl max-w-6xl max-w-7xl max-w-8xl max-w-9xl"

</script>





<Stack class="container max-w-{size} w-full {className}" {...restProps}>
	{@render children?.()}
</Stack>