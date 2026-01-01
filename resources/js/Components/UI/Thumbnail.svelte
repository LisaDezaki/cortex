<script>

	import clsx from 'clsx'
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
		thumbnail: clsx('thumbnail overflow-hidden shrink-0', aspect, className),
		image:     clsx('thumbnail-image min-h-full min-w-full object-cover', imageClass),
		fallback:  clsx('thumbnail-fallback font-black h-full text-neutral-softer text-5xl tracking-tighter w-full'),
		icon:      clsx('thumbnail-icon text-neutral-softest opacity-50')
	})

</script>



<Inline align="center" justify="center" class={cx.thumbnail} {...restProps}>
	{#if src}
		<img class={cx.image} {src} {alt} />
	{:else}
		<Inline align="center" justify="center" class={cx.fallback}>
			{#if icon}
				<Icon class={cx.icon} name={icon} size={iconSize} weight="fill" />
			{/if}
		</Inline>
	{/if}
</Inline>