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
		iconOptions,
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
		<Link class="card-link absolute inset-0 z-10" href={href}></Link>
	{/if}

	{#if options}
		<ContextMenu
			class="absolute inset-0 z-10"
			iconOptions={iconOptions}
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

		.card-visual {
			@apply flex-shrink-0 rounded-lg overflow-hidden w-full;
			/* background: var(--bg-neutral-gradient); */
			background-color: var(--bg-neutral-softest);
			/* border-color: var(--border-neutral-softest); */
			&:not(.grid) {
				@apply flex items-center justify-center;
			}

			.card-image {
				@apply min-h-full min-w-full object-cover;
			}

			:global(.card-icon) {
				@apply aspect-square p-6 rounded-full max-h-[60%] max-w-[60%] h-full w-full;
				color: var(--text-neutral-softest);
			}
		}

		.card-details {
			@apply px-1 w-full;
		}

		:global(.card-dropdown) {
			@apply absolute;
			z-index: 5;
		}

		:global(.card-item-options-button) {
			opacity: 0;
		}
	}

</style>