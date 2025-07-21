<script>

	import Button from '@/Components/Button.svelte'
	import Icon from '@/Components/Icon.svelte'

	let {
		children,
		class: className,
		href,
		...attrs
	} = $props()

</script>

<div class="sticky top-6 ml-6 h-0">
	<Button class="rounded-full h-12 w-12 hover:text-emerald-500 {className}"
		icon="ArrowLeft"
		iconSize={32}
		iconWeight="light"
	{href} {...attrs} />
</div>