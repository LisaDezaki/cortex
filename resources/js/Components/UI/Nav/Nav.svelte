<script>

	import clsx from 'clsx'
	import Stack from '@/Components/Core/Stack.svelte'

    let {
		children,
        class: className,
		header,
		footer,
        ...restProps
    } = $props()

	const cx = {
		nav:  clsx('nav border-r h-full min-w-12 w-56 max-w-72 shrink-0',
					'bg-accent-strong border-neutral-softest text-nav-link',
					className),
		list: clsx('nav-list py-2')
	}

</script>



<Stack as="nav" class={cx.nav} {...restProps}>

	{#if header}
		{@render header()}
	{/if}

	{#if children}
		<Stack as="ul" class="{cx.list} scrollable mb-auto">
			{@render children()}
		</Stack>
	{/if}

	{#if footer}
		<Stack as="ul" class={cx.list}>
			{@render footer()}
		</Stack>
	{/if}

</Stack>