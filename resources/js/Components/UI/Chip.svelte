<script>
	import clsx from 'clsx'
	import { Link } from '@inertiajs/svelte'
	import { Flex, Popover, Stack }  from '@/Components/Core'
	import Button   from '@/Components/UI/Button.svelte'
	import Dropdown from '@/Components/UI/Dropdown.svelte'
	import Icon     from '@/Components/UI/Icon.svelte'

    let {
		active,
		aspect,
		children,
		class: className,
		href,
		image,
		icon,
		onclick,
		options,
		state = 'default',
		text,
		title,
		subtitle,
		subtitleClass,
        ...restProps
    } = $props()

	const clickable = $derived(href || onclick)

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		chip: clsx({
			'chip border px-2 py-0.5 rounded': true,
			'border-neutral-softest': state !== 'active',
			'bg-accent-softest border-transparent text-accent': state === 'active',
			'cursor-pointer': href || onclick,
			'pl-1.5': state === 'active' || icon,
		}, className),
		visual: clsx({
			'chip-visual aspect-square rounded-full overflow-hidden': true,
		})
	})

</script>



<Flex class={cx.chip}
	align="center" gap={1} onclick={onclick}
{...restProps}>

	{#if image || icon || state === 'active'}
		<div class={cx.visual}>
			{#if image}
				<img class="chip-image" src={image} alt={title} />
			{:else if state === 'active'}
				<Icon class="chip-icon text-accent" name="Check" size="sm" weight="bold" />
			{:else if icon}
				<Icon class="chip-icon text-accent" name={icon} size="sm" />
			{/if}
		</div>
	{/if}

	<div class="chip-details">
		{#if children}
			<span class="line-clamp-1 break-all w-full">{@render children()}</span>
		{:else if title}
			<span class="line-clamp-1 break-all w-full">{title}</span>
		{:else if text}
			<span class="line-clamp-1 break-all w-full">{text}</span>
		{/if}
		<!-- {#if subtitle}
			<span class="font-style-small line-clamp-1 w-full {subtitleClass}">{subtitle}</span>
		{/if} -->
	</div>

	{#if href}
		<Link class="card-link" href={href}></Link>
	{/if}

</Flex>