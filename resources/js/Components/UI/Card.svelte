<script>
	import { Link } from '@inertiajs/svelte'

	import { Flex, Popover, Stack }  from '@/Components/Core';
	
	import Button   from '@/Components/UI/Button.svelte';
	import Dropdown from '@/Components/UI/Dropdown.svelte';
	import Icon     from '@/Components/UI/Icon.svelte';

    let {
		aspect,
		class: className,
		href,
		image,
		icon,
		onclick,
		options,
		title,
		subtitle,
        ...restProps
    } = $props()

	const clickable = $derived(href || onclick) 

</script>

<Stack class="card {clickable ? "cursor-pointer" : null} {className}" onclick={onclick} {...restProps}>

	{#if href}
		<Link class="card-link" href={href}></Link>
	{/if}

	<div class="card-visual aspect-{aspect}">
		{#if image}
			<img class="card-image" src={image} alt={title} />
		{:else if icon}
			<Icon class="card-icon" name={icon} size={32} />
		{/if}
	</div>

	<Flex justify="start" class="w-full">
		<div class="card-details -space-y-0.5">
			<span class="font-style-small font-semibold line-clamp-1 w-full">{title}</span>
			{#if subtitle}
				<span class="font-style-tiny line-clamp-1 w-full">{subtitle}</span>
			{/if}
		</div>
		{#if options}

			<!-- <Dropdown class="card-dropdown"
				icon="DotsThreeOutlineVertical"
				options={options}
			/> -->
	
			<Popover class="card-dropdown">
				<Button style="plain" theme="neutral" class="card-item-options-button rounded-full" icon="DotsThreeOutlineVertical" iconSize={16} iconWeight="fill" />
				{#snippet content()}
					<Stack class="py-1">
						{#each options as option}
							<Link class="flex gap-2 px-2 py-1 hover:bg-slate-500/10" {...option}>
								<Icon class="mt-[2px]" name={option.icon} />
								{option.label}
							</Link>
						{/each}
					</Stack>
				{/snippet}
			</Popover>
		{/if}
	</Flex>

</Stack>

<style lang="postcss">

	:global(.card) {
		@apply relative flex flex-col flex-shrink-0 gap-1.5 min-w-24 mb-3 rounded-lg overflow-hidden;
		&:hover {
			.card-visual {
				background-color: var(--bg-card-hover);
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
			@apply flex-shrink-0 flex items-center justify-center rounded-lg overflow-hidden w-full;
			background-color: var(--bg-card);

			.card-image {
				@apply min-h-full min-w-full object-cover;
			}

			:global(.card-icon) {
				@apply aspect-square p-6 rounded-full;
				background-color: var(--bg-neutral-softest);
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