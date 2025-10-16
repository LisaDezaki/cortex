<script>
	import { Link } from '@inertiajs/svelte'
	import { Avatar } from "bits-ui"
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
</script>

{#if showIf}
	<Avatar.Root class="navatar {className} {restProps.square ? 'square' : ''}" {...restProps}>
		<Avatar.Image class="navatar-image" src={src} alt={alt}></Avatar.Image>
		<Avatar.Fallback class="navatar-fallback">{fallback}</Avatar.Fallback>
		{#if href}
			<Link class="absolute inset-0" href={href}></Link>
		{/if}
	</Avatar.Root>
{/if}

<style lang="postcss">

	:global(.navatar) {
		@apply relative inline-flex items-center justify-center aspect-square overflow-hidden p-[1px] flex-shrink-0 w-8;
		@apply border cursor-pointer rounded-full tracking-tighter;
		border-color: var(--border-accent);
		&:hover {
			border-color: var(--border-white);
			:global(.navatar-fallback) {
				color: var(--text-white);
			}
		}
	}

	:global(.navatar-image) {
		@apply object-cover h-full w-full rounded-full;
	}

	:global(.navatar-fallback) {
		@apply flex items-center justify-center w-full h-full;
		@apply rounded-full font-light;
		color: var(--text-accent);
	}

</style>