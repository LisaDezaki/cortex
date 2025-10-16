<script>
	import Box from '@/Components/Core/Box.svelte'

	let {
		class: className,
		color = 'bg-neutral-softest',
		...restProps
	} = $props()
</script>

<Box class="{color} rounded-full {className}" {...restProps} />