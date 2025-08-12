<script>
	import { onMount } from 'svelte'
	import { Combobox } from "bits-ui";

	import Icon      from '@/Components/UI/Icon.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	let {
		children,
		class: className,
		contentClass,
		icon,
		multiple = false,
		options,
		placeholder = "Select one...",
		value = $bindable(),
        ...restProps
    } = $props()

	let input
	let hasFocus    = $state(false)
	let selection   = $state(null)
	let query       = $state('')

	function checkFocus() {
		hasFocus = document.activeElement === input;
	}

	export function focus() {
        input?.focus()
    }

	const sortedValues = $derived(
		value.length
		? value.sort((a,b) => a < b ? -1 : 1)
		: []
	)

	const filteredOptions = $derived(
		query === ''
		? options
		: options
			.filter((option) =>
				option.label.toLowerCase().includes(query.toLowerCase())
			).sort((a,b) =>
				a.label.localeCompare(b.label)
			)
	);

	function removeItem(index) {
		value = value.filter((_, i) => i !== index)
	}	

	

    onMount(() => {
        if (restProps.autofocus && input) {
            input.focus()
			checkFocus()
        }
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

<!-- {#snippet option(item)}
	{#if item?.image}
		<Thumbnail class="rounded-full w-6" src={item.image} />
	{/if}
	{#if item?.icon}
		<Icon name={item.icon} size={20} weight="regular" />
	{/if}
	{#if item?.label}
		<span class="line-clamp-1">{item.label}</span>
	{/if}
{/snippet} -->

<!-- {#snippet selectedValue()}
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
{/snippet} -->





<Combobox.Root
	type={multiple ? "multiple" : "single"}
	onOpenChange={(o) => { if (!o) query = '' }}
{...restProps}>

	<!-- Trigger -->

	<div class="{className} input-combobox" class:disabled={restProps.disabled} class:focus={hasFocus}>
		{#if icon}
			<Icon class="input-icon" name={icon} size={20} weight="regular" />
		{/if}
		<Combobox.Input
			bind:value={value}
			class="combobox-input w-auto"
			oninput={(e) => (query = e.currentTarget.value)}
			placeholder={placeholder}
		/>
		<Combobox.Trigger class="input-action ml-auto">
			<Icon name="CaretUpDown" size={16} weight="light" />
		</Combobox.Trigger>
	</div>



	<!-- Content -->

	<Combobox.Portal>
		<Combobox.Content
			class="{contentClass} max-h-[var(--bits-combobox-content-available-height)] w-[var(--bits-combobox-anchor-width)] min-w-[var(--bits-combobox-anchor-width)]"
			align="start"
			sideOffset={-1}
		>
			<Combobox.ScrollUpButton class="flex w-full items-center justify-center opacity-50">
				<Icon name="CaretDoubleUp" size={12} />
			</Combobox.ScrollUpButton>

			<Combobox.Viewport>
				{#each filteredOptions as opt, i (i + opt.value)}
					<Combobox.Item
						class="input-option"
						value={opt.value}
						label={opt.label}
						disabled={opt?.disabled}
					>
						{@render option(opt)}
						{#if value == opt.value}
							<Icon class="ml-auto" name="Check" />
						{/if}
					</Combobox.Item>
				{:else}
					<span class="block px-5 py-2 text-sm text-muted-foreground">
						No results found, try again.
					</span>
				{/each}
			</Combobox.Viewport>

			<Combobox.ScrollDownButton class="flex w-full items-center justify-center opacity-50">
				<Icon name="CaretDoubleDown" size={12} />
			</Combobox.ScrollDownButton>

		</Combobox.Content>
	</Combobox.Portal>
</Combobox.Root>