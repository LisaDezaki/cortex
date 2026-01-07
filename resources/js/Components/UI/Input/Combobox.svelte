<script>
    import { onMount } from 'svelte'
	import { Combobox } from "bits-ui";

	import { Flex, Inline, Stack } from '@/Components/Core'
	import Icon      from '@/Components/UI/Icon.svelte'
	import Input 	 from '@/Components/UI/Input'
	import Label     from '@/Components/UI/Label.svelte'
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
		onUpdate = () => {},
		options,
		overrideLabel,
		placeholder = "Select one...",
		rootClass,
		size = "md",
		value = $bindable(),
        ...restProps
    } = $props()

    let input
	let hasFocus  = $state(false)
	let selection = $state(null)
	let isEmpty   = $derived(value == null || value == '' || value == [])
	let type	  = $derived(multiple ? 'multiple' : 'single')

	let selectedOption = $derived(options.find(o => o.value === value) || {placeholder, value})
	
	let filteredOptions = $derived(
		value === ""
		? options
		: options.filter((opt) =>
			opt.label.toLowerCase().includes(value.toLowerCase())
			)
	)

	function checkFocus() {
		hasFocus = document.activeElement === input;
	}

    export function focus() {
        input?.focus()
    }

	function getLabel(value) {
		return options.find(o => o.value == value)?.label || ''
	}

	function updateValue(e) {
		value = e.currentTarget.value
	}

	function updateSelection() {
		// console.log(selectedOption, onUpdate)
		onUpdate(selectedOption)
	// 	if (!multiple) {
	// 		selection = val ? options.find(o => o.value === val || o.label === val) : null
	// 	} else if (multiple) {
	// 		selection = val ? options.filter(o => val.includes(o.value) || val.includes(o.label)) : null
	// 	}
	}

    // onMount(() => {
    //     if (restProps.autofocus && input) {
    //         input.focus()
	// 		checkFocus()
    //     }
	// 	updateSelection(value)
    // })

</script>








<pre>{JSON.stringify({
	value
}, null, 3)}</pre>


<Combobox.Root class="select"
	bind:this={input}
	bind:value
	type={type}
	items={options}
	onfocus={checkFocus}
	onblur={checkFocus}
	onOpenChangeComplete={o => value = !o ? '' : value}
	onValueChange={updateSelection}
{...restProps}>

	<Inline class="input p-{size} {className}">
		{#if icon}
		<Icon class="input-icon" name={icon} size={size} />
		{/if}
		<Combobox.Input class="input-input appearance-none p-0" oninput={updateValue} />
		<Combobox.Trigger>
			<Icon name="CaretUpDown" size="xs" />
		</Combobox.Trigger>
	</Inline>

	<Combobox.Portal class="z-50 {contentClass}">
		<Combobox.Content
			class="input-content {contentClass} px-0.5 py-0.5 z-50"
			align="start" sideOffset={-1}
		>
			<!-- <Select.ScrollUpButton class="flex w-full items-center justify-center opacity-50">
				<Icon name="CaretDoubleUp" size="xs" />
			</Select.ScrollUpButton> -->

			<Combobox.Viewport>
				<Stack>
					{#each filteredOptions as option, i}
						{#if option.separator}
							<Separator class="mx-2 my-0.5 w-auto" />
						{:else if option.options}
							<div class="opacity-50 px-2 py-1">{option.label}</div>
							<Stack>
								{#each option.options as opt}
									<Combobox.Item {...opt}>
										<Input.Option item={opt} class="p-{size}" size={size} />
									</Combobox.Item>
								{/each}
							</Stack>
						{:else}
							<Combobox.Item {...option}>
								<Input.Option item={option} class="p-{size}" size={size} />
							</Combobox.Item>
						{/if}
					{:else}
						<span class="block px-3 py-1.5 text-sm text-neutral-soft">
							No results found.
						</span>
					{/each}
				</Stack>
			</Combobox.Viewport>

			<!-- <Select.ScrollDownButton class="flex w-full items-center justify-center opacity-50">
				<Icon name="CaretDoubleDown" size="xs" />
			</Select.ScrollDownButton> -->

		</Combobox.Content>
	</Combobox.Portal>
</Combobox.Root>