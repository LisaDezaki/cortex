<script>

	import { Link } from '@inertiajs/svelte'
	import { Avatar } from "bits-ui"
	import Icon from '@/Components/UI/Icon.svelte';

	let {
		alt,
		children,
		class: className,
		href,
		size,
		src,
		...restProps
	} = $props()

</script>

<Link href={href} class="character_icon {className}">
	<Avatar.Root class="charactericon" {...restProps}>
		<Avatar.Image class="charactericon-image" src={src} alt={alt}></Avatar.Image>
		<Avatar.Fallback class="charactericon-fallback">
			<Icon name="User" size={20} weight="fill" class="charactericon-icon" />
		</Avatar.Fallback>
	</Avatar.Root>
</Link>

<style lang="postcss">

	:global(.character_icon) {
		@apply inline-flex bg-slate-200 items-center justify-center h-9 w-9 rounded-full overflow-hidden;
		/* @apply border; */
		/* background-color: var(--bg-surface); */
		/* border-color: var(--border-neutral-softest); */
		&:hover {
			@apply z-10;
		}
	}

	:global(.charactericon-icon) {
		@apply relative inline-flex items-center justify-center h-9 w-9 rounded-full overflow-hidden flex-shrink-0;
		color: var(--text-neutral-softest);
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