<script>

	import clsx from 'clsx'
	import Flex from '@/Components/Core/Flex.svelte'
	import Inline from '@/Components/Core/Inline.svelte'
	import Icon from '@/Components/UI/Icon.svelte'

	let {
		alt,
		aspect = "aspect-square",
		children,
		class: className = '',
		icon,
		iconSize = 20,
		imageClass,
		src,
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		thumbnail: clsx('thumbnail relative overflow-hidden shrink-0', aspect, className),
		image:     clsx('thumbnail-image group-hover:grayscale-[0.75] group-hover:contrast-75 group-hover:saturate-200 min-h-full min-w-full object-cover', imageClass),
		fallback:  clsx('thumbnail-fallback  font-black h-full text-neutral-softer text-5xl tracking-tighter w-full'),
		icon:      clsx('thumbnail-icon text-neutral-softest opacity-50'),
		overlay:   clsx('thumbnail-overlay absolute inset-0 bg-emerald-400 opacity-0 group-hover:opacity-35')
	})

</script>



<Inline align="center" justify="center" class={cx.thumbnail} {...restProps}>
	{#if src}
		<img class={cx.image} {src} {alt} />
		<Flex class={cx.overlay}></Flex>
	{:else}
		<Inline align="center" justify="center" class={cx.fallback}>
			{#if icon}
				<Icon class={cx.icon} name={icon} size={iconSize} weight="fill" />
			{/if}
		</Inline>
	{/if}
	
</Inline>