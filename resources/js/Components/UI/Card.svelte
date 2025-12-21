<script>
	import { Link } from '@inertiajs/svelte'
	import Flex			from '@/Components/Core/Flex.svelte';
	import Stack		from '@/Components/Core/Stack.svelte';
	import Button		from '@/Components/UI/Button.svelte'
	import ContextMenu	from '@/Components/UI/ContextMenu.svelte'
	import Icon			from '@/Components/UI/Icon.svelte';
    import clsx from 'clsx'

    let {
		active,
		aspect,
		children,
		class: className,
		href,
		image,
		imageClass,
		icon,
		iconOptions,
		onclick,
		onStar,
		options,
		starrable,
		starred,
		thumbnailIcon,
		title,
		subtitle,
		subtitleClass,
        ...restProps
    } = $props()

	// const clickable = $derived(restProps.disabled ? false : (href || onclick))

	let cx = $derived({
		card: clsx({
			'card group border border-transparent relative shrink-0 min-w-24 mb-1 p-1 rounded-md overflow-hidden': true,
			'bg-transparent text-neutral': !active,
			'bg-accent-softest border text-accent': active,
			'cursor-pointer': restProps.disabled ? false : (href || onclick),
			'text-accent': active,
			'cursor-not-allowed': restProps.disabled
		}, className),
		top: clsx({
			'card-visual overflow-hidden rounded shrink-0 w-full': true,
			'bg-accent-softer': active,
			'bg-neutral-softest group-hover:bg-neutral-softer': !active,
			'hover:bg-neutral-gradient-alt hover:border-accent': image,
			'opacity-35 pointer-events-none': restProps.disabled
		}, `aspect-${aspect}`, imageClass),
		img:  clsx('card-image min-h-full object-cover', {
			'group-hover:mix-blend-multiply': image,
		}),
		icon: clsx('card-icon aspect-square h-full max-h-[60%] max-w-[60%] opacity-35 p-6 rounded-full text-neutral-softest w-full'),
		main: clsx('pl-1 w-full'),
		details: clsx({
			'card-details pb-0.5 -space-y-0.5 shrink-1 w-full': true,
			'opacity-35 pointer-events-none': restProps.disabled
		}),
		title:   clsx('font-style-small font-semibold line-clamp-1 truncate w-full'),
		subtitle: clsx('font-style-tiny line-clamp-1 truncate w-full', subtitleClass),
		link: clsx('card-link absolute inset-0 text-transparent z-10'),
	})

</script>



<Stack gap={0.5}
	class={cx.card}
	onclick={onclick}
{...restProps}>

	<Flex align="center" justify="center" class={cx.top}>
		{#if image}
			<img class={cx.img} src={image} alt={title} />
		{:else if thumbnailIcon}
			<Icon class={cx.icon} name={thumbnailIcon} size={32} weight="fill" />
		{/if}
		{@render children?.()}
	</Flex>

	<Flex align="center" justify="start" gap={2} class={cx.main}>
		<Stack class={cx.details} gap={0}>
			<span class={cx.title}>{title}</span>
			{#if subtitle}
				<span class={cx.subtitle}>{subtitle}</span>
			{/if}
		</Stack>
		<Button class="rounded-full {active ? 'text-danger' : 'text-accent'} {active ? 'inline' : 'hidden group-hover:inline'}"
			theme={active ? undefined : "accent"}
			icon={active ? "XCircle" : "ArrowCircleRight"} iconSize="lg" iconWeight="light"
		/>
	</Flex>

	{#if href}
		<Link class={cx.link} href={href} />
	{/if}

	{#if starrable}
		<Button
			class="absolute bottom-1 right-0 z-10 {starred ? '' : 'show-on-hover'} {starred ? 'text-amber-400 hover:text-amber-300' : 'text-neutral-softest hover:text-amber-400'}"
			icon="Star" iconSize="md" iconWeight={starred ? 'fill' : 'light'}
			onclick={onStar}
		/>
	{/if}

</Stack>