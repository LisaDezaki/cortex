<script>
	import { Link } from '@inertiajs/svelte'
	import { ContextMenu } from "bits-ui";

	import { Flex, Grid, Stack } from '@/Components/Core';
	import Button from '@/Components/UI/Button.svelte';
	import Icon from '@/Components/UI/Icon.svelte';

  let {
	children,
	class: className,
	icon,
	iconSize = 16,
	iconWeight = 'regular',
	iconOptions,
	label,
	options,
	...restProps
  } = $props()

  
</script>









{#snippet item(item)}
	<Flex
		align="center" gap={2}
		class="relative cursor-pointer px-3 py-1.5 rounded w-full
			{item.disabled			 ? 'text-neutral-softest'	:	'' }
			{item.theme === 'accent' ? 'text-accent' : '' }
			{item.theme === 'danger' ? 'text-danger' : '' }
			{item.theme === undefined ? 'text-neutral-strong active:text-accent' : '' }
		">

		{#if item.icon}
			<Icon name={item.icon} class={item.active ? "text-accent": ""}
				size={item.iconSize || iconSize} weight={item.iconWeight || iconWeight}
			/>
		{/if}
		
		{#if item.label}
			<span class="font-style-small line-clamp-1 truncate">{item.label}</span>
		{/if}

		{#if item.options}
			<Icon name="CaretRight" size="sm" class="ml-auto -mr-2 text-neutral-softer" />
		{/if}

		{#if item.active}
			<Icon name="Check" size="sm" class="ml-auto text-accent" />
		{/if}

		{#if item.disabled}
			<Icon name="X" size="sm" class="ml-auto text-danger" />
		{/if}

		{#if item.onclick}
			<button class="absolute inset-0 text-transparent" onclick={(e) => item.onclick(e, item)}>{item.label}</button>
		{:else if item.href}
			<Link class="absolute inset-0 text-transparent" href={item.href}>{item.label}</Link>
		{/if}

	</Flex>
{/snippet}

<ContextMenu.Root {...restProps}>
	<ContextMenu.Trigger class="{className} select-none">
		{#if icon}
			<Icon name={icon} size={iconSize} weight={iconWeight} />
		{/if}
		{#if label}
			<span>{label}</span>
		{/if}
		{@render children?.()}
	</ContextMenu.Trigger>
	<ContextMenu.Portal>
		<ContextMenu.Content class="bg-white border border-neutral-softer max-h-96 outline-none overflow-y-auto p-1 rounded-lg shadow-xl w-48 focus-visible:outline-none">

			{#if iconOptions}
				<Grid cols={iconOptions.length} gap={0} class="w-full">
					{#each iconOptions.map(opt => ({...opt, iconSize: "md", iconWeight: "regular" })) as iconOption}
						<ContextMenu.Item class="grow rounded hover:bg-{iconOption.theme || 'neutral'}-softest">
							{@render item(iconOption)}
						</ContextMenu.Item>
					{/each}
				</Grid>
				<ContextMenu.Separator class="block border-t border-neutral-softest my-1" />
			{/if}

			{#each options as option}

				{#if option.hasOwnProperty('hideIf') && option.hideIf === true}
					<!-- Skip rendering this option -->
				{:else if option.separator}
					<ContextMenu.Separator class="block border-t border-neutral-softest my-1" />
				{:else if option.options}
					<ContextMenu.Sub>
						<ContextMenu.SubTrigger class="data-[state=open]:bg-neutral-softest rounded">
							{@render item(option)}
						</ContextMenu.SubTrigger>
						<ContextMenu.SubContent
							class="bg-white border border-neutral-softer outline-none rounded-lg shadow-xl w-48 z-100 ring-0! ring-transparent!"
							sideOffset={4}
						>
							<Flex align="center" class="border-b border-neutral-softest p-1 text-neutral-soft w-full z-10">
								<span class="line-clamp-1 px-3 truncate">{option.label}</span>
								<!-- <Button style="soft" theme="accent" class="h-8 w-8 ml-auto"
									icon="Plus" size="sm"
									onclick={option.create}
								/> -->
								<ContextMenu.Item class="h-8 w-8 ml-auto">
									<Button style="plain" theme="accent" class="h-8 w-8 ml-auto"
										icon="Plus" size="sm"
										onclick={option.create}
									/>
								</ContextMenu.Item>
							</Flex>
							{#if option.options.length > 0}
								<Stack class="max-h-96 overflow-y-auto p-1" gap={0}>
									{#each option.options as opt}
										<ContextMenu.Item class="hover:bg-{opt.theme || 'neutral'}-softest rounded">
											{@render item(opt)}
										</ContextMenu.Item>
									
									{/each}
								</Stack>
							{:else}
								<div class="text-center font-style-placeholder px-4 py-2">
									No options
								</div>
							{/if}
						</ContextMenu.SubContent>
					</ContextMenu.Sub>
				{:else}
					<ContextMenu.Item class="hover:bg-{option.theme || 'neutral'}-softest rounded">
						{@render item(option)}
					</ContextMenu.Item>
				{/if}

			{/each}
		</ContextMenu.Content>
	</ContextMenu.Portal>
</ContextMenu.Root>