<script>

	import Button from '@/Components/UI/Button.svelte'

	let {
		children,
		class: className,
		href,
		icon,
		...restProps
	} = $props()

</script>

<Button {href} 
	class="rounded-full h-10 w-10 border border-neutral-softest hover:text-emerald-500 {className}"
	icon={icon || "ArrowLeft"} iconSize="lg" iconWeight="bold"
{...restProps} />