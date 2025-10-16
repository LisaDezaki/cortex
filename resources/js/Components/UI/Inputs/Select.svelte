<script>
    import { onMount } from 'svelte'
	import { Select } from "bits-ui";

	import { Flex, Stack } from '@/Components/Core'
	import Icon      from '@/Components/UI/Icon.svelte'
	import InputItem from '@/Components/UI/Inputs/InputItem.svelte'
	import Label     from '@/Components/UI/Inputs/Label.svelte'
	import Separator from '@/Components/UI/Separator.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	let {
		children,
		class: className,
		contentClass,
		icon,
		iconSize,
		inputClass,
		label,
		labelIcon,
		multiple = false,
		options,
		overrideLabel,
		placeholder = "Select one...",
		onUpdate = () => {},
		value = $bindable(),
        ...restProps
    } = $props()

    let input
	let hasFocus  = $state(false)
	let selection = $state(null)
	let isEmpty   = $derived(value == null || value == '' || value == [])

	function checkFocus() {
		hasFocus = document.activeElement === input;
	}

    export function focus() {
        input?.focus()
    }

	function updateSelection(val) {
		if (!multiple) {
			selection = val ? options.find(o => o.value === val || o.label === val) : null
		} else if (multiple) {
			selection = val ? options.filter(o => val.includes(o.value) || val.includes(o.label)) : null
		}
		onUpdate(options.find(o => o.value === val))
	}

    onMount(() => {
        if (restProps.autofocus && input) {
            input.focus()
			checkFocus()
        }
		updateSelection(value)
    })

</script>







<!-- {#snippet selectedValue()}
	{#if !multiple}
		{@render optionContent(selection)}
	{:else if multiple}
		<Flex justify="start" gap={1} wrap class="overflow-hidden">
			{#each selection as selectionValue}
				<Flex align="center" gap={1} class="bg-slate-500/5 flex-shrink-0 h-8 px-1.5 py-0.5 rounded">
					{@render optionContent(selectionValue)}
				</Flex>
			{/each}
		</Flex>
	{/if}
{/snippet} -->

{#snippet optionItem(item)}
	<Select.Item
		label={item?.label}
		value={item?.value}
		disabled={item?.disabled}
	>
		<InputItem item={item} />
	</Select.Item>
{/snippet}

<!-- {#snippet optionContent(item)}
	{#if item?.image}
		<Thumbnail class="rounded-full w-6" src={item.image} />
	{/if}
	{#if item?.icon}
		<Icon name={item.icon} size={20} weight="regular" />
	{/if}
	{#if item?.label}
		<span class="line-clamp-1 text-left w-full">{item.label}</span>
	{/if}
{/snippet} -->





<Select.Root class="select"
	bind:this={input}
	bind:value={value}
	type={multiple ? "multiple" : "single"}
	items={options}
	onfocus={checkFocus}
	onblur={checkFocus}
	onValueChange={updateSelection}
{...restProps}>


	<!-- Trigger -->

	<Select.Trigger class="input flex flex-col gap-0 -space-y-1 {className}">
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

		<Flex align="center" justify="start" class="p-1 w-full">
			<InputItem item={selection} />
			<!-- {#if icon && !selection?.icon && !selection?.image}
				<Icon class="input-icon" name={icon} size={iconSize} weight="regular" />
			{/if}
			<div class="input-value {icon ? "pl-icon" : ""} {inputClass}" class:font-style-placeholder={isEmpty}>
				{#if isEmpty}
					{placeholder}
				{:else if overrideLabel}
					{overrideLabel}
				{:else}
					{@render selectedValue()}
				{/if}
			</div>
			<Icon class="input-action" name="CaretUpDown" size="xs" weight="light" /> -->
		</Flex>

	</Select.Trigger>



	<!-- Content -->
	 
	<Select.Portal class="z-50">
		<Select.Content
			class="input-content {contentClass} min-w-[var(--bits-select-anchor-width)] p-0.5 z-50"
			align="start" sideOffset={-1}
		>
			<Select.ScrollUpButton class="flex w-full items-center justify-center opacity-50">
				<Icon name="CaretDoubleUp" size="xs" />
			</Select.ScrollUpButton>

			<Select.Viewport>
				<Stack>
					{#each options as option, i}
						{#if option.separator}
							<Separator class="mx-2 my-0.5 w-auto" />
						{:else if option.options}
							<div class="font-medium opacity-50 px-2 py-1 text-sm">{option.label}</div>
							{#each option.options as opt}
								<!-- {opt.icon} -->
								{@render optionItem(opt)}
								<!-- <InputItem item={opt} /> -->
							{/each}
						{:else}
							<!-- {option.icon} -->
							{@render optionItem(option)}
							<!-- <InputItem item={option} /> -->
						{/if}
					{:else}
						<span class="block px-5 py-2 text-sm text-muted-foreground">
							No results found, try again.
						</span>
					{/each}
				</Stack>
			</Select.Viewport>

			<Select.ScrollDownButton class="flex w-full items-center justify-center opacity-50">
				<Icon name="CaretDoubleDown" size="xs" />
			</Select.ScrollDownButton>

		</Select.Content>
	</Select.Portal>

</Select.Root>