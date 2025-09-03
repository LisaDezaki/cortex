<script>
	import { Link } from '@inertiajs/svelte'
	import { ContextMenu } from "bits-ui";

	import { Flex } from '@/Components/Core';
	import Icon from '@/Components/UI/Icon.svelte';

  let {
	children,
	class: className,
	icon,
	iconSize = 16,
	iconWeight = 'light',
	label,
	options,
	...restProps
  } = $props()

  
</script>









{#snippet item(item)}
	<Flex
		align="center" gap={2}
		class="relative cursor-pointer px-3 py-1.5 w-full
			{item.disabled			 ? 'text-neutral-softest'	:	'' }
			{item.theme === 'accent' ? 'text-accent hover:bg-accent-softest' : '' }
			{item.theme === 'danger' ? 'text-danger hover:bg-danger-softest' : '' }
			{item.theme === undefined ? 'text-neutral-strong active:text-accent hover:bg-neutral-softest' : '' }
		">

		{#if item.icon}
			<Icon name={item.icon} class={item.active ? "text-accent": ""}
				size={item.iconSize || iconSize} weight={item.iconWeight || iconWeight}
			/>
		{/if}
		
		{#if item.label}
			<span class="font-style-small">{item.label}</span>
		{/if}

		{#if item.options}
			<Icon name="CaretRight" size="sm" class="ml-auto text-neutral-softer" />
		{/if}

		{#if item.active}
			<Icon name="Check" size="sm" class="ml-auto text-accent" />
		{/if}

		{#if item.disabled}
			<Icon name="X" size="sm" class="ml-auto text-danger" />
		{/if}

		{#if item.onclick}
			<button class="absolute inset-0 text-transparent" onclick={item.onclick}>{item.label}</button>
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
		<ContextMenu.Content class="bg-surface border border-accent outline-none py-1 rounded-lg shadow-xl w-48 focus-visible:outline-none">
			{#each options as option}

				{#if option.separator}
					<ContextMenu.Separator class="block border-t border-neutral-softest my-1" />
				{:else if option.options}
					<ContextMenu.Sub>
						<ContextMenu.SubTrigger>
							{@render item(option)}
						</ContextMenu.SubTrigger>
						<ContextMenu.SubContent
							class="bg-surface border border-accent outline-none py-1 rounded-lg shadow-xl w-48 z-100 ring-0! ring-transparent!"
							sideOffset={0}
						>
							{#each option.options as opt}
								<ContextMenu.Item>
									{@render item(opt)}
								</ContextMenu.Item>
							{/each}
						</ContextMenu.SubContent>
					</ContextMenu.Sub>
				{:else}
					<ContextMenu.Item>
						{@render item(option)}
					</ContextMenu.Item>
				{/if}

			{/each}

				<!-- <ContextMenu.Sub>
					<ContextMenu.SubTrigger class="rounded-button data-highlighted:bg-muted data-[state=open]:bg-muted flex h-10 select-none items-center py-3 pl-3 pr-1.5 text-sm font-medium focus-visible:outline-none">
						<div class="flex items-center">Add</div>
					</ContextMenu.SubTrigger>
					<ContextMenu.SubContent
						class="border-muted bg-background shadow-popover z-100 ring-0! ring-transparent! w-[209px] rounded-xl border px-1 py-1.5"
						sideOffset={10}
					>
					<ContextMenu.Item
						class="rounded-button data-highlighted:bg-muted flex h-10 select-none items-center py-3 pl-3 pr-1.5 text-sm font-normal focus-visible:outline-none"
					>
						Header
					</ContextMenu.Item>
					<ContextMenu.Item
						class="rounded-button data-highlighted:bg-muted flex h-10 select-none items-center py-3 pl-3 pr-1.5 text-sm font-normal focus-visible:outline-none"
					>
						Paragraph
					</ContextMenu.Item>
					<ContextMenu.Item
						class="rounded-button data-highlighted:bg-muted flex h-10 select-none items-center py-3 pl-3 pr-1.5 text-sm font-normal focus-visible:outline-none"
					>
						Codeblock
					</ContextMenu.Item>
					<ContextMenu.Item
						class="rounded-button data-highlighted:bg-muted flex h-10 select-none items-center py-3 pl-3 pr-1.5 text-sm font-normal focus-visible:outline-none"
					>
						List
					</ContextMenu.Item>
					<ContextMenu.Item
						class="rounded-button data-highlighted:bg-muted flex h-10 select-none items-center py-3 pl-3 pr-1.5 text-sm font-normal focus-visible:outline-none"
					>
						Task
					</ContextMenu.Item>
					</ContextMenu.SubContent>
				</ContextMenu.Sub>

				<ContextMenu.Item class="rounded-button data-highlighted:bg-muted flex h-10 select-none items-center py-3 pl-3 pr-1.5 text-sm font-medium focus-visible:outline-none">
					<div class="flex items-center">Duplicate</div>
				</ContextMenu.Item>

				<ContextMenu.Separator class="bg-muted -mx-1 my-1 block h-px" />

				<ContextMenu.Item class="rounded-button data-highlighted:bg-muted flex h-10 select-none items-center py-3 pl-3 pr-1.5 text-sm font-medium focus-visible:outline-none">
					<div class="flex items-center">Delete</div>
				</ContextMenu.Item> -->

		</ContextMenu.Content>
	</ContextMenu.Portal>
</ContextMenu.Root>