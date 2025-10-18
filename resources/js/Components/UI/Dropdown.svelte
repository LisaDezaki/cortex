<script>
	import { Link } from '@inertiajs/svelte'
	import { Popover } from "bits-ui"

	import Flex      from '@/Components/Core/Flex.svelte'
	import Grid      from '@/Components/Core/Grid.svelte'
	import Stack     from '@/Components/Core/Stack.svelte'
	import Button    from '@/Components/UI/Button.svelte'
	import Icon      from '@/Components/UI/Icon.svelte'
	import Label     from '@/Components/UI/Inputs/Label.svelte'
	import Input     from '@/Components/UI/Input.svelte'
	import InputItem from '@/Components/UI/Inputs/InputItem.svelte'
	import Separator from '@/Components/UI/Separator.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	let {
        class: className,
		icon,
		inputClass,
		label,
		labelIcon,
		isOpen = $bindable(false),
		options,
		placeholder,
		size = "md",
		onUpdate = () => {},
		value = $bindable()
    } = $props()

	const padSizes = {
		xs: "py-0",
		sm: "py-0.25",
		md: "py-0.5",
		lg: "py-1",
		xl: "py-1.5"
	}

	let suboptionQuery 		= $state('')
	let suboptions	   		= $state(null)
	let filteredSuboptions 	= $derived(suboptions?.filter(s => `${s.value} ${s.label}`.toLowerCase().includes(suboptionQuery.toLowerCase()) ))

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

	function back() {
		suboptionQuery = ''
		suboptions = null
	}

	let selected = $state(options.find(o => o.value === value) || {})

</script>



<!-- {#snippet item(itemProps, checked)}
	<Flex gap={1} class="input-option text-sm w-full {itemProps.className} {checked ? 'active' : ''}" onclick={() => selectItem(itemProps)}>
		{#if itemProps.icon !== undefined}
			<Icon name={itemProps.icon} size="md" />
		{/if}
		{#if itemProps.image !== undefined}
			<Thumbnail class="border-[0.5px] p-[1px] rounded-full w-5" imageClass="rounded-full" iconSize={16} src={itemProps.image} />
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
{/snippet} -->

<Popover.Root bind:open={isOpen}>
	<Stack gap={0.5}>
		{#if label}
			<Flex align="center" justify="start" gap={1} class="font-light pt-0.5 pl-1 text-neutral-soft w-full">
				{#if labelIcon}
					<Icon name={labelIcon} size="xs" />
				{/if}
				<Label
					class="font-style-label"
					value={label}
				/>
			</Flex>
		{/if}
		<Popover.Trigger class="input p-1 {className}">
			<InputItem item={selected} class={padSizes[size]} />
		</Popover.Trigger>
	</Stack>

	<Popover.Portal>
		<Popover.Content
			class="input-content overflow-hidden {className}"
			align="start" sideOffset={-1}
		>
			<Grid cols={2} gap={0} class="max-h-96 w-[200%] {suboptions ? 'translate-x-[-50%]' : ''} transition-transform">
				<Stack class="p-0.5">
					{#each options as option}
						{#if !option.hideIf}
							{#if option.separator}
								<Separator class="mx-2 my-0.5 w-auto" />
							{:else}
								<InputItem item={option} onclick={() => selectItem(option)} />
							{/if}
						{/if}
					{/each}
				</Stack>
				<Stack class="relative max-h-full overflow-hidden">
					<Flex align="center" gap={0} class="bg-white p-0.5 w-full">
						<Button style="plain" theme="neutral" size="md" icon="CaretLeft" iconSize="sm" class="hover:bg-neutral-softest text-neutral-softest focus:outline-none border-none" onclick={back} />
						<input bind:value={suboptionQuery} class="border-none p-1 rounded text-neutral font-style-input w-28" placeholder="Search" />
						<Button size="md" icon="Plus" iconSize="sm" theme="accent" class="ml-auto" />
					</Flex>
					<Separator class="mx-2 w-auto" />
					<div class="overflow-y-auto p-0.5 max-h-80">
						{#each filteredSuboptions as suboption}
							<!-- {@render item(suboption)} -->
							<InputItem item={suboption} onclick={() => selectItem(suboption)} />
						{:else}
							<p class="font-style-placeholder text-center">0 results.</p>
						{/each}
					</div>
				</Stack>
			</Grid>
		</Popover.Content>
	</Popover.Portal>
</Popover.Root>