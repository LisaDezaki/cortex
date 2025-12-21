<script>
	import Box from '@/Components/Core/Box.svelte'
	import Flex from '@/Components/Core/Flex.svelte'
	import Inline from '@/Components/Core/Inline.svelte'
	import Icon from '@/Components/UI/Icon.svelte'
	import clsx from 'clsx'

	let {
		align = 'center',
		children,
		class: className,
		justify = 'center',
		name
	} = $props()

	let cx = {
		demo:    clsx('bg-neutral-softest min-h-96 relative overflow-y-auto p-6 rounded w-full', className),
		overlay: clsx('absolute inset-0 bg-[radial-gradient(169.40%,89.55%_at_94.76%_6.29%,rgba(0,0,0,0.40)_0%,rgba(255,255,255,0.00)_100%)')
	}
</script>

<Flex {align} {justify} gap={2} class={cx.demo} style="background-image: url('/img/grid.png'); background-size: 16px; background-position: 8px 8px;">
	<Box class={cx.overlay}></Box>
	<Inline gap={1.5} class="absolute top-0 left-0 p-2 text-neutral-softest text-sm uppercase"><Icon name="DiamondsFour" size="md" weight="light" />{name}</Inline>
	<Flex class='relative p-6' gap={3}>
		<div class="h-2 w-2 border-t border-l border-accent-soft absolute top-0 left-0"></div>
		<div class="h-2 w-2 border-t border-r border-accent-soft absolute top-0 right-0"></div>
		<div class="h-2 w-2 border-b border-l border-accent-soft absolute bottom-0 left-0"></div>
		<div class="h-2 w-2 border-b border-r border-accent-soft absolute bottom-0 right-0"></div>
		{@render children?.()}
	</Flex>
</Flex>