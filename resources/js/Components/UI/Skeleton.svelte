<script>

	import clsx from 'clsx'
	import Box from '@/Components/Core/Box.svelte'

	let {
		border = 'rounded',
		class: className,
		color = 'bg-slate-100',
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		skeleton: clsx(border, color, className)
	})

</script>

<Box class={cx.skeleton} {...restProps} />