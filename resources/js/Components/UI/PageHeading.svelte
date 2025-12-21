<script>
	import Stack from '@/Components/Core/Stack.svelte'
	import Heading from '@/Components/UI/Heading.svelte'
	import clsx from 'clsx'

	let {
		class: className,
		title,
		subtitle
	} = $props()

	let cx = {
		heading: clsx('', className)
	}
</script>

<Stack class={cx.heading}>
	<Heading is="h1" as="h3" class="text-neutral">{title}</Heading>
	<p class="text-lg text-neutral-softer">{subtitle}</p>
</Stack>