<script>

	import { Link } from '@inertiajs/svelte'
	import { Avatar } from "bits-ui"
    import clsx from 'clsx'

	let {
		alt,
		children,
		class: className,
		fallback = "",
		href,
		if: showIf = true,
		src,
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		navatar:  clsx({
			'navatar relative inline-flex items-center justify-center': true,
			'aspect-square cursor-pointer overflow-hidden p-[1px] shrink-0 tracking-tighter w-8': true,
			'border border-accent hover:border-white rounded-full': true
		}, className),
		image:    clsx('navatar-image h-full object-cover rounded-full w-full'),
		fallback: clsx('navatar-fallback flex items-center justify-center font-light h-full rounded-full text-accent w-full'),
		link:     clsx('absolute inset-0')
	})

</script>



{#if showIf}
	<Avatar.Root class={cx.navatar} {...restProps}>
		<Avatar.Image class={cx.image} src={src} alt={alt}></Avatar.Image>
		<Avatar.Fallback class={cx.fallback}>{fallback}</Avatar.Fallback>
		{#if href}<Link class={cx.link} href={href}></Link>{/if}
	</Avatar.Root>
{/if}