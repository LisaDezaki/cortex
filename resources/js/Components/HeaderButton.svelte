<script>
	import Button from '@/Components/Button.svelte'

	let {
		children,
		class: className,
		...restProps
	} = $props()
</script>

<Button class="border-l rounded-none {className}"
	iconSize={24} iconWeight="light"
	{...restProps}
/>