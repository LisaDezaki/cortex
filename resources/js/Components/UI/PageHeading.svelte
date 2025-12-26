<script>
	import Stack from '@/Components/Core/Stack.svelte'
	import Heading from '@/Components/UI/Heading.svelte'
	import clsx from 'clsx'

	let {
		class: className,
		is = 'h1',
		as = 'h3',
		title,
		subtitle
	} = $props()

	let cx = {
		heading: 	clsx('', className),
		title:	 	clsx('text-neutral'),
		subtitle:	clsx('text-lg text-neutral-softer')
	}
</script>

<Stack class={cx.heading}>
	<Heading {is} {as} class={cx.title}>{title}</Heading>
	<p class={cx.subtitle}>{subtitle}</p>
</Stack>