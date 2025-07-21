<script>

	import { Avatar } from "bits-ui"
	import Icon from "@/Components/Icon.svelte";

	let {
		alt,
		children,
		class: className,
		icon,
		src,
		...attrs
	} = $props()

</script>

<Avatar.Root class="thumbnail {className}" {...attrs}>
	<Avatar.Image class="thumbnail-image" src={src} alt={alt}></Avatar.Image>
	<Avatar.Fallback class="thumbnail-fallback">
		<Icon size={24} name={icon || "ImageSquare"} class="thumbnail-icon" />
	</Avatar.Fallback>
</Avatar.Root>

<style lang="postcss">

	:global(.thumbnail) {
		@apply relative inline-flex items-center justify-center aspect-square overflow-hidden flex-shrink-0;
	}

	:global(.thumbnail:not([class*="rounded"])) {
		@apply rounded-lg;
	}

	:global(.thumbnail-image) {
		@apply object-cover min-h-full min-w-full;
	}

	:global(.thumbnail-fallback) {
		@apply flex items-center justify-center w-full h-full;
		@apply text-slate-900 font-black text-5xl tracking-tighter;
		@apply rounded-md;
	}

	:global([data-theme="light"] .thumbnail:not([class*="border-"])) {
		@apply border-slate-300;
	}
	:global([data-theme="light"] .thumbnail-fallback) {
		@apply bg-slate-200 text-slate-100;
	}
	:global([data-theme="light"] .thumbnail-icon) {
		@apply text-slate-400;
	}

	:global([data-theme="dark"] .thumbnail:not([class*="border-"])) {
		@apply border-slate-600;
	}
	:global([data-theme="dark"] .thumbnail-fallback) {
		@apply bg-slate-800 text-slate-900;
	}
	:global([data-theme="dark"] .thumbnail-icon) {
		@apply text-slate-600;
	}
	
</style>