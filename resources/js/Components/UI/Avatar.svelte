<script>
	import Icon from '@/Components/UI/Icon.svelte'
	import clsx from 'clsx'
	import { Avatar } from "bits-ui"

	let {
		alt,
		children,
		class: className,
		fallback,
		status,
		src,
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		avatar:   clsx('aspect-square border border-neutral-softest inline-flex items-center justify-center overflow-hidden p-0.5 rounded-full shrink-0', className),
		image:	  clsx('h-full object-cover rounded-full w-full'),
		fallback: clsx('bg-neutral-softer flex items-center justify-center h-full rounded-full text-neutral-soft w-full')
	})

	let emptyText = $derived(fallback || "—")

</script>



<Avatar.Root class="{cx.avatar} {restProps.square ? 'square' : ''}" data-status={status} {...restProps}>
	{#if status === 'loading'}
		<Icon name="CircleNotch" class="bg-accent-softest p-1 rounded-full text-accent" animation="animate-spin" />
	{:else if status === 'loaded'}
		<Avatar.Image class={cx.image} src={src} alt={alt} data-status={status}></Avatar.Image>
	{:else}
		<Avatar.Fallback class={cx.fallback} data-status={status}>{emptyText}</Avatar.Fallback>
	{/if}
</Avatar.Root>