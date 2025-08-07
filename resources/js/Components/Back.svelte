<script>

	import Button from '@/Components/Button.svelte'

	let {
		children,
		class: className,
		href,
		...restProps
	} = $props()

</script>

<div class="sticky top-8 ml-6 h-0">
	<Button {href} {...restProps}
		class="rounded-full h-12 w-12 hover:text-emerald-500 {className}"
		icon="ArrowLeft" iconSize={32} iconWeight="light"
	/>
</div>