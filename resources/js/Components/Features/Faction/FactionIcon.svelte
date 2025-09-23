<script>

	import { Link } from '@inertiajs/svelte'
	import { Avatar } from "bits-ui"
	import Icon from '@/Components/Icon.svelte'

	let {
		alt,
		children,
		class: className,
		href,
		icon,
		size,
		src,
		...restProps
	} = $props()

</script>

<Link href={href} class={className}>
	{#if src}
		<Avatar.Root class="factionicon" {...restProps}>
			<Avatar.Image class="factionicon-image" src={src} alt={alt}></Avatar.Image>
			<Avatar.Fallback class="factionicon-fallback"><Icon size={24} name={icon || "User"} class="factionicon-icon" /></Avatar.Fallback>
		</Avatar.Root>
		{:else if icon}
		<div class="factionicon-icon">
			<Icon class="rounded-full w-full aspect-square" name="FlagBannerFold" size={20} />
		</div>
	{/if}
</Link>

<style lang="postcss">

	:global(.factionicon),
	:global(.factionicon-icon) {
		@apply relative inline-flex items-center justify-center h-9 w-9 aspect-square rounded-lg overflow-hidden flex-shrink-0 border-2;
		background-color: var(--bg-neutral-softest);
		border-color: var(--border-neutral-softest);
		&:hover {
			@apply z-10;
		}
	}

	/* :global(.thumbnail) {
		@apply relative inline-flex items-center justify-center aspect-square overflow-hidden flex-shrink-0;
		@apply rounded-full font-black text-5xl tracking-tight;
	} */

	/* :global(.thumbnail-image) {
		@apply object-cover h-full w-full;
	} */

	/* :global(.thumbnail-fallback) {
		@apply flex items-center justify-center w-full h-full;
		@apply text-slate-900 font-black text-5xl tracking-tighter;
		@apply rounded-md;
	} */

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