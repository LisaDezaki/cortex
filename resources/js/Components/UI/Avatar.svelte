<script>

	import { Avatar } from "bits-ui"

	let {
		alt,
		children,
		class: className,
		fallback = "AB",
		if: showIf = true,
		src,
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = {
		avatar: "aspect-square border border-neutral-softest inline-flex items-center justify-center overflow-hidden p-0.5 rounded-full shrink-0" + className,
		image:	"h-full object-cover  rounded-full w-full",
		fallback: "bg-neutral-softer flex items-center justify-center h-full rounded-full text-neutral-soft w-full"
	}

</script>



{#if showIf}
	<Avatar.Root class="{cx.avatar} {restProps.square ? 'square' : ''}" {...restProps}>
		<Avatar.Image class={cx.image} src={src} alt={alt}></Avatar.Image>
		<Avatar.Fallback class={cx.fallback}>{fallback}</Avatar.Fallback>
	</Avatar.Root>
{/if}