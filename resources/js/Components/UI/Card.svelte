<script>
	import { Link } from '@inertiajs/svelte'


	//	Components

	import Flex			from '@/Components/Core/Flex.svelte';
	import Stack		from '@/Components/Core/Stack.svelte';
	import Button		from '@/Components/UI/Button.svelte'
	import ContextMenu	from '@/Components/UI/ContextMenu.svelte'
	import Icon			from '@/Components/UI/Icon.svelte';


	//	Component props

    let {
		aspect,
		children,
		class: className,
		href,
		image,
		imageClass,
		icon,
		iconSize = 32,
		iconWeight = "fill",
		iconOptions,
		onclick,
		onStar,
		options,
		starred,
		title,
		subtitle,
		subtitleClass,
        ...restProps
    } = $props()

	const clickable = $derived(restProps.disabled ? false : (href || onclick))

</script>

<Stack gap={1}
	class="card {clickable ? "cursor-pointer" : null} {className}"
	onclick={onclick}
{...restProps}>

	<Flex class="card-visual aspect-{aspect} {imageClass}">
		{#if image}
			<img class="card-image" src={image} alt={title} />
		{:else if icon}
			<Icon class="card-icon opacity-35" name={icon} size={iconSize} weight={iconWeight} />
		{/if}
		{@render children?.()}
	</Flex>

	<Flex justify="start" class="w-full">
		<div class="card-details -space-y-0.5">
			<span class="font-style-small font-semibold line-clamp-1 w-full">{title}</span>
			{#if subtitle}
				<span class="font-style-tiny line-clamp-1 w-full {subtitleClass}">{subtitle}</span>
			{/if}
		</div>
	</Flex>

	{#if href}
		<Link
			class="card-link absolute inset-0 text-transparent z-10"
			href={href}
		/>
	{/if}

	{#if options}
		<ContextMenu
			class="flex items-center justify-center absolute bottom-1 right-0 h-7 w-7 show-on-hover hover:bg-neutral-softest rounded-full z-10"
			icon="DotsThreeOutlineVertical" iconWeight="fill"
			iconOptions={iconOptions}
			options={options}
		/>
	{/if}

	<Button
		class="absolute bg-tint-radial top-0 left-0 z-10 {starred ? '' : 'show-on-hover'} {starred ? 'text-amber-400 hover:text-amber-300' : 'text-white hover:text-amber-400'}"
		icon="Star" iconSize="md" iconWeight={starred ? 'fill' : 'light'}
		onclick={onStar}
	/>

</Stack>

<style lang="postcss">

	:global(.card .show-on-hover) {
		@apply opacity-0 pointer-events-none;
	}
	:global(.card:hover .show-on-hover) {
		@apply opacity-100 pointer-events-auto;
	}

	:global(.card) {
		@apply relative flex flex-col flex-shrink-0 min-w-24 mb-3 rounded-lg overflow-hidden;
		&:not([disabled="true"]):hover {
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
		&[disabled="true"] { cursor: not-allowed; }
		&[disabled="true"] .card-image,
		&[disabled="true"] .card-icon,
		&[disabled="true"] .card-details {
			opacity: 0.35;
			pointer-events: none;
		}

		:global(.card-visual) {
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
				@apply aspect-square h-full max-h-[60%] max-w-[60%] p-6 rounded-full w-full;
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