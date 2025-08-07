<script>
    import { onMount } from 'svelte'
	import { Select } from "bits-ui";

	import Icon from '@/Components/Icon.svelte'
	import Thumbnail from '@/Components/Thumbnail.svelte'

	let {
		children,
		class: className,
		contentClass,
		icon,
		multiple = false,
		options,
		overrideLabel,
		placeholder = "Select one...",
		value = $bindable(),
        ...restProps
    } = $props()

    let input
	let hasFocus    = $state(false)
	let selection   = $state(null)
	let isEmpty     = $derived(value == null || value == '' || value == [])

	function checkFocus() {
		hasFocus = document.activeElement === input;
	}

    export function focus() {
        input?.focus()
    }

	function updateSelection(val) {
		value = val
		if (!multiple) {
			selection = val ? options.find(o => o.value === val) : null
		} else if (multiple) {
			selection = val ? options.filter(o => val.includes(o.value)) : null
		}
	}

    onMount(() => {
        if (restProps.autofocus && input) {
            input.focus()
			checkFocus()
        }
		updateSelection(value)
    })

</script>





{#snippet option(item)}
	{#if item?.image}
		<Thumbnail class="rounded-full w-6" src={item.image} />
	{/if}
	{#if item?.icon}
		<Icon name={item.icon} size={20} weight="regular" />
	{/if}
	{#if item?.label}
		<span class="line-clamp-1">{item.label}</span>
	{/if}
{/snippet}

{#snippet selectedValue()}
	{#if !multiple}
		{@render option(selection)}
	{:else if multiple}
		<div class="inline-flex justify-start gap-1 overflow-hidden">
			{#each selection as selectionValue}
				<div class="bg-slate-500/5 flex-shrink-0 inline-flex items-center gap-1 h-8 px-1.5 py-0.5 rounded">
					{@render option(selectionValue)}
				</div>
			{/each}
		</div>
	{/if}
{/snippet}





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

	<Select.Trigger class="{className} input-select {restProps.disabled ? "disabled" : ""} {hasFocus ? "focus" : ""}">

		{#if icon && !selection?.icon && !selection?.image}
			<Icon class="input-icon" name={icon} size={20} weight="regular" />
		{/if}

		<div class="input-value {icon ? "pl-icon" : ""}">
			{#if isEmpty}
				{placeholder}
			{:else if overrideLabel}
				{overrideLabel}
			{:else}
				{@render selectedValue()}
			{/if}
		</div>

		<Icon class="input-action" name="CaretUpDown" size="sm" weight="light" />

	</Select.Trigger>



	<!-- Content -->
	 
	<Select.Portal>
		<Select.Content
			class="{contentClass} min-w-[var(--bits-select-anchor-width)]"
			align="start"
			sideOffset={-1}
		>
			<Select.ScrollUpButton class="flex w-full items-center justify-center opacity-50">
				<Icon name="CaretDoubleUp" size="xs" />
			</Select.ScrollUpButton>

			<Select.Viewport>
				{#each options as opt, i (i + opt.value)}
					<Select.Item
						class="input-option"
						label={opt?.label}
						value={opt?.value}
						disabled={opt?.disabled}
					>
						{@render option(opt)}
						{#if value == opt.value}
							<Icon class="ml-auto" name="Check" size="sm" />
						{/if}
					</Select.Item>
				{:else}
					<span class="block px-5 py-2 text-sm text-muted-foreground">
						No results found, try again.
					</span>
				{/each}
			</Select.Viewport>

			<Select.ScrollDownButton class="flex w-full items-center justify-center opacity-50">
				<Icon name="CaretDoubleDown" size="xs" />
			</Select.ScrollDownButton>

		</Select.Content>
	</Select.Portal>

</Select.Root>