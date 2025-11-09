<script>

	import Button from '@/Components/UI/Button.svelte'

	let {
		children,
		class: className,
		href,
		icon,
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = {
		back: "rounded-full h-10 w-10 border border-neutral-softest hover:text-emerald-500" + className,
	}

</script>



<Button {href} 
	class={cx.back}
	icon={icon || "ArrowLeft"} iconSize="lg" iconWeight="bold"
{...restProps} />