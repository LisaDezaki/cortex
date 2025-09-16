<script>

	import { Avatar } from "bits-ui"
	import Icon from "@/Components/UI/Icon.svelte";

	let {
		alt,
		children,
		class: className,
		icon,
		src,
		...restProps
	} = $props()

</script>

<!-- <Avatar.Root class="thumbnail {className}" {...restProps}>
	<Avatar.Image class="thumbnail-image" src={src} alt={alt}></Avatar.Image>
	<Avatar.Fallback class="thumbnail-fallback">
		<Icon class="thumbnail-icon" name={icon || "ImageSquare"} size={20} weight="light" />
	</Avatar.Fallback>
</Avatar.Root> -->

<div class="thumbnail {className}" {...restProps}>
	{#if src}
		<img {src} alt={restProps.alt || ''} class="thumbnail-image" />
	{:else}
		<div class="thumbnail-fallback">
			<Icon class="thumbnail-icon" name={icon || "ImageSquare"} size={20} weight="light" />
		</div>
	{/if}
</div>

<style lang="postcss">

	:global(.thumbnail) {
		@apply inline-flex items-center justify-center aspect-square overflow-hidden flex-shrink-0;
		background-color: var(--bg-neutral-softest);
	}

	:global(.thumbnail:not([class*="rounded"])) {
		@apply rounded-lg;
	}

	:global(.thumbnail-image) {
		@apply object-cover min-h-full min-w-full;
	}

	:global(.thumbnail-fallback) {
		@apply flex items-center justify-center w-full h-full;
		@apply font-black text-5xl tracking-tighter;
		@apply rounded-md;
		color: var(--text-neutral-softer);
	}

	/* :global([data-theme="light"] .thumbnail:not([class*="border-"])) {
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
	} */
	
</style>