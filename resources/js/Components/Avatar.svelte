<script>
	import { Avatar } from "bits-ui"
	let {
		alt,
		children,
		class: className,
		fallback = "AB",
		src,
		...attrs
	} = $props()
</script>

<Avatar.Root class="avatar {className} {attrs.square ? 'square' : ''}" {...attrs}>
	<Avatar.Image class="avatar-image" src={src} alt={alt}></Avatar.Image>
	<Avatar.Fallback class="avatar-fallback">{fallback}</Avatar.Fallback>
</Avatar.Root>

<style lang="postcss">

	:global(.avatar) {
		@apply inline-flex items-center justify-center aspect-square overflow-hidden p-0.5 flex-shrink-0;
		@apply border rounded-full;
		@apply font-black text-lg tracking-tighter;
	}
	:global(.avatar:not([class*="border-"])) {
		border-color: var(--border-input);
	}

	:global(.avatar-image) {
		@apply object-cover h-full w-full rounded-full;
	}

	:global(.avatar-fallback) {
		@apply flex items-center justify-center w-full h-full;
		@apply rounded-full;
		background-color: var(--background-alt);
		color: var(--text-subtle);
	}

</style>