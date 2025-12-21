<script>

	import clsx from 'clsx'
    import { Link } from '@inertiajs/svelte'
	import Flex from '@/Components/Core/Flex.svelte'
	import Badge from '@/Components/UI/Badge.svelte'
	import Icon  from '@/Components/UI/Icon.svelte'

    let {
        active = false,
		badge,
		children,
		class: className,
		icon,
		label,
        ...restProps
    } = $props()

	const cx = {
		item: clsx('nav-item block leading-5 rounded text-sm hover:text-white',
					'transition duration-150 ease-in-out',
					{'active bg-accent-softest text-white':active}),
		link: clsx('nav-link flex items-center gap-3 p-2 w-full', {active}, className),
		badge: clsx('ml-auto bg-white/10 text-white rounded')
	}

</script>



<Flex as="li" class={cx.item}>

	<Link
		{...restProps}
		class={cx.link}
	>
		{#if icon}
			<Icon name={icon} size={20} />
		{/if}

		{#if label}
			<span>{label}</span>
		{/if}

		{#if children}
			{@render children()}
		{/if}

		{#if badge}
			<Badge text={badge} class={cx.badge} />
		{/if}
		
	</Link>
</Flex>