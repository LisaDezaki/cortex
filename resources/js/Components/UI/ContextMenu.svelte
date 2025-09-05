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

		</ContextMenu.Content>
	</ContextMenu.Portal>
</ContextMenu.Root>