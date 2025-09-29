<script>
	import { Link } from '@inertiajs/svelte'
	import { Popover } from "bits-ui"

	import Flex      from '@/Components/Core/Flex.svelte'
	import Grid      from '@/Components/Core/Grid.svelte'
	import Stack     from '@/Components/Core/Stack.svelte'
	import Button    from '@/Components/UI/Button.svelte'
	import Icon      from '@/Components/UI/Icon.svelte'
	import Input     from '@/Components/UI/Input.svelte'
	import Separator from '@/Components/UI/Separator.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	let {
		children,
        class: className,
		contentClass,
		content,
		icon,
		label,
		isOpen = $bindable(),
		options,
		placeholder,
		trigger,
		onUpdate = () => {},
		value = $bindable()
    } = $props()

	let suboptions = $state(null)

	function selectItem(option) {
		if (option.options) {
			suboptions = option.options
		} else {
			value = option.value
			selected = option
			isOpen = false
			onUpdate(option)
		}
	}

	let selected = $state(options.find(o => o.value === value) || {})

</script>



{#snippet item(itemProps, checked)}
	<Flex gap={2} class="input-option px-1 w-full {itemProps.className} {checked ? 'active' : ''}" onclick={() => selectItem(itemProps)}>
		{#if itemProps.icon !== undefined}
			<Icon name={itemProps.icon} size="md" />
		{/if}
		{#if itemProps.image !== undefined}
			<Thumbnail class="border-[0.5px] rounded-full w-6" iconSize={16} src={itemProps.image} />
		{/if}
		{#if itemProps.label}
			<span class="line-clamp-1 text-left w-full">{itemProps.label}</span>
		{:else if itemProps.placeholder}
			<span class="line-clamp-1 text-left w-full font-style-placeholder">{itemProps.placeholder}</span>
		{/if}
		{#if itemProps.options}
			<Icon name="CaretRight" size="sm" class="text-neutral-softest ml-auto" />
		{/if}
		{#if checked}
			<Icon name="Check" size="sm" class="ml-auto" />
		{/if}
	</Flex>
{/snippet}

<Popover.Root open={isOpen}>
	<Popover.Trigger class="input {className}">
		{@render item({ className, icon, ...selected })}
	</Popover.Trigger>
 
	<Popover.Portal>
		<Popover.Content class="input-content overflow-hidden {className}">
			<Grid cols={2} gap={0} class="w-[200%] {suboptions ? 'translate-x-[-50%]' : ''} transition-transform">
				<Stack class="p-1">
					{#each options as option}
						{#if !option.hideIf}
							{#if option.separator}
								<Separator class="mx-2 my-1 w-auto" />
							{:else}
								{@render item(option)}
							{/if}
						{/if}
					{/each}
				</Stack>
				<Stack class="relative overflow-hidden">
					<Flex align="center" gap={0} class="sticky top-0 bg-white border-b p-1 w-full">
						<Button size="md" icon="CaretLeft" iconSize="sm" class="text-neutral-softest" onclick={() => suboptions = null} />
						<input class="border-none px-0 py-0.5 rounded w-28" placeholder="Search" />
						<Button size="sm" icon="Plus" theme="accent" class="ml-auto" />
					</Flex>
					<div class="overflow-y-auto p-1">
						{#each suboptions as suboption}
							{@render item(suboption)}
						{/each}
					</div>
				</Stack>
			</Grid>
		</Popover.Content>
	</Popover.Portal>
</Popover.Root>