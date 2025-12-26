<script>
	import clsx 	from 'clsx'
	import Flex 	from '@/Components/Core/Flex.svelte'
	import Button 	from '@/Components/UI/Button.svelte'
	import Icon 	from '@/Components/UI/Icon.svelte'

	let {
		alt,
		class: className,
		imageClass,
		icon,
		iconSize = "xl",
		iconWeight = "light",
		media,
		name,
		onclick,
		url
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		media:  clsx('media overflow-hidden', className),
		img:    clsx('min-h-full min-w-full object-cover', imageClass),
		icon:   clsx('opacity-50 text-neutral-softest'),
		button: clsx('absolute inset-0')
	})

</script>



<Flex align="center" justify="center" class={cx.media}>

	{#if url}
		<img class={cx.img} src={url} alt={alt} />
	{/if}
	{#if media}
		<img class={cx.img} src={media.url} alt={media.name} />
	{:else if icon}
		<Icon class={cx.icon} name={icon} size={iconSize} weight={iconWeight} />
	{/if}
	{#if onclick}
		<Button class={cx.button} onclick={onclick} />
	{/if}
</Flex>