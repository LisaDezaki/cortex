<script>

	import clsx from 'clsx'
	import Button from '@/Components/UI/Button.svelte'

	let {
		children,
		class: className,
		href,
		icon = 'ArrowLeft',
		text,
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		back: clsx('rounded-full border border-neutral-softest hover:text-emerald-500', className),
	})

</script>



<Button {href} 
	class={cx.back}
	icon={icon} iconSize="lg" iconWeight="regular"
	text={text}
{...restProps} />