<script>
	import { Link } from '@inertiajs/svelte'

	import { Flex, Popover, Stack }  from '@/Components/Core';
	
	import Button		from '@/Components/UI/Button.svelte';
	import ContextMenu	from '@/Components/UI/ContextMenu.svelte'
	import Dropdown		from '@/Components/UI/Dropdown.svelte';
	import Icon			from '@/Components/UI/Icon.svelte';

    let {
		aspect,
		children,
		class: className,
		href,
		image,
		imageClass,
		icon,
		onclick,
		options,
		title,
		subtitle,
		subtitleClass,
        ...restProps
    } = $props()

	const clickable = $derived(href || onclick) 

</script>

<Stack class="card {clickable ? "cursor-pointer" : null} {className}" onclick={onclick} {...restProps}>

	<div class="card-visual aspect-{aspect} {imageClass}">
		{#if children}
			{@render children()}
		{:else if image}
			<img class="card-image" src={image} alt={title} />
		{:else if icon}
			<Icon class="card-icon" name={icon} size={32} />
		{/if}
	</div>

	<Flex justify="start" class="w-full">
		<div class="card-details -space-y-0.5">
			<span class="font-style-small font-semibold line-clamp-1 w-full">{title}</span>
			{#if subtitle}
				<span class="font-style-tiny line-clamp-1 w-full {subtitleClass}">{subtitle}</span>
			{/if}
		</div>
	</Flex>

	{#if href}
		<Link class="card-link" href={href}></Link>
	{/if}

	{#if options}
		<ContextMenu
			class="absolute inset-0 z-10"
			options={options}
		/>
	{/if}

</Stack>

<style lang="postcss">

	:global(.card) {
		@apply relative flex flex-col flex-shrink-0 gap-1.5 min-w-24 mb-3 rounded-lg overflow-hidden;
		&:hover {
			.card-visual {
				background: var(--bg-neutral-gradient-alt)!important;
				border-color: var(--border-accent)!important;
			}
			:global(.card-icon) {
				background: var(--bg-neutral-gradient-alt-flip)!important;
				color: var(--text-accent)!important;
			}
			.card-image {
				mix-blend-mode: multiply;
			}
			.card-details {
				color: var(--text-accent);
			}
			:global(.card-item-options-button) {
				opacity: 1;
			}
		}
		&[disabled="true"] {
			opacity: 0.35;
			pointer-events: none;
		}

		:global(.card-link) {
			@apply absolute inset-0;
			z-index: 1;
		}

		.card-visual {
			@apply border flex-shrink-0 rounded-lg overflow-hidden p-1.5 w-full;
			background: var(--bg-neutral-gradient);
			border-color: var(--border-neutral-softest);
			&:not(.grid) {
				@apply flex items-center justify-center;
			}

			.card-image {
				@apply min-h-full min-w-full object-cover;
			}

			:global(.card-icon) {
				@apply aspect-square p-6 rounded-full max-h-[60%] max-w-[60%] h-full w-full;
				background: var(--bg-neutral-gradient-flip);
				color: var(--text-neutral-softest);
			}
		}

		.card-details {
			@apply px-1 w-full;
		}

		:global(.card-dropdown) {
			/* @apply absolute top-2 right-2; */
			@apply absolute;
			z-index: 5;
		}

		:global(.card-item-options-button) {
			/* @apply backdrop-blur-sm h-8 w-8; */
			/* background-color: rgba(0,0,0,0.15); */
			/* color: var(--text-white); */
			opacity: 0;
			&:hover {
				/* background-color: rgba(255,255,255,0.2); */
			}
		}
	}

</style>