<script>
	import Box from '@/Components/Core/Box.svelte'

	let {
		border = 'rounded',
		class: className,
		color = 'bg-slate-100',
		...restProps
	} = $props()
</script>

<Box class="{border} {color} {className}" {...restProps} />