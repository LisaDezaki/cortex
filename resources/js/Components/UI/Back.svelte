<script>

	import Button from '@/Components/UI/Button.svelte'

	let {
		children,
		class: className,
		href,
		...restProps
	} = $props()

</script>

<!-- <div> -->
	<Button {href} {...restProps}
		class="rounded-full h-10 w-10 border border-neutral-softest hover:text-emerald-500 {className}"
		icon="ArrowLeft" iconSize="lg" iconWeight="bold"
	/>
<!-- </div> -->