<script>

	import { Avatar } from "bits-ui"
	import Icon from '@/Components/UI/Icon.svelte'

	let {
		alt,
		children,
		class: className,
		icon,
		iconSize = 20,
		imageClass,
		src,
		...restProps
	} = $props()

</script>





<div class="thumbnail {className}" {...restProps}>
	{#if src}
		<img {src} alt={restProps.alt || ''} class="thumbnail-image {imageClass}" />
	{:else}
		<div class="thumbnail-fallback">
			{#if icon}
				<Icon class="thumbnail-icon text-neutral-softest opacity-50" name={icon} size={iconSize} weight="fill" />
			{/if}
		</div>
	{/if}
</div>

<style lang="postcss">

	:global(.thumbnail) {
		@apply inline-flex items-center justify-center aspect-square overflow-hidden flex-shrink-0;
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