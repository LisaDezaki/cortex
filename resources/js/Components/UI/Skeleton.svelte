<script>
	import Box from '@/Components/Core/Box.svelte'

	let {
		border = 'rounded',
		class: className,
		color = 'bg-neutral-softest',
		...restProps
	} = $props()
</script>

<Box class="{border} {color} {className}" {...restProps} />