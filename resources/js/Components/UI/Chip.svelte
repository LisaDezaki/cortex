<script>
	import { Link } from '@inertiajs/svelte'

	import { Flex, Popover, Stack }  from '@/Components/Core';
	
	import Button   from '@/Components/UI/Button.svelte';
	import Dropdown from '@/Components/UI/Dropdown.svelte';
	import Icon     from '@/Components/UI/Icon.svelte';

    let {
		aspect,
		children,
		class: className,
		href,
		image,
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

<Flex class="chip {clickable ? "cursor-pointer" : null} {className}"
	align="center" gap={3} onclick={onclick}
{...restProps}>

	<div class="chip-visual aspect-square rounded-full overflow-hidden w-12">
		{#if image}
			<img class="chip-image" src={image} alt={title} />
		{:else if icon}
			<Icon class="chip-icon" name={icon} size={32} />
		{/if}
	</div>

	<Flex class="w-full" justify="start">
		<div class="chip-details -space-y-0.5">
			{#if children}
				<span class="font-semibold line-clamp-1 w-full">{@render children()}</span>
			{:else if title}
				<span class="font-semibold line-clamp-1 w-full">{title}</span>
			{/if}
			{#if subtitle}
				<span class="font-style-small line-clamp-1 w-full {subtitleClass}">{subtitle}</span>
			{/if}
		</div>
		{#if options}

			<!-- <Dropdown class="chip-dropdown"
				icon="DotsThreeOutlineVertical"
				options={options}
			/> -->
	
			<Popover class="chip-dropdown">
				<Button style="plain" theme="neutral" class="chip-item-options-button rounded-full" icon="DotsThreeOutlineVertical" iconSize={16} iconWeight="fill" />
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

	{#if href}
		<Link class="card-link" href={href}></Link>
	{/if}

</Flex>

<style lang="postcss">

	:global(.chip) {
		
	}

</style>