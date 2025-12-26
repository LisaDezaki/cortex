<script>

	import Box from './Box.svelte';

	let {
		align = 'stretch',
		children,
		class: className,
		direction = 'row',
		gap = 0,
		justify = 'start',
		wrap = false,
		...restProps
	} = $props()

	let cx = {
		align:		'items-start items-end items-end-safe items-center items-center-safe items-baseline items.baseline-last items-stretch',
		justify:	'justify-start justify-end justify-end-safe justify-center justify-center-safe justify-between justify-around justify-evenly justify-stretch justify-baseline justify-normal',
		gap:		'gap-1 gap-2 gap-3 gap-4 gap-5 gap-6'
	}

</script>

<Box class="flex flex-{direction} items-{align} justify-{justify} {wrap ? 'flex-wrap' : ''} gap-{gap} {className}" {...restProps}>
	{@render children?.()}
</Box>