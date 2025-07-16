<!-- SCRIPT -->

<script>

	//	Import onMount from Svelte to handle component lifecycle
    import { onMount } from 'svelte'

	//  Import Components to use within this component
	import { Select } from "bits-ui";
	import Button from '@/Components/Button.svelte'
	import Icon from '@/Components/Icon.svelte'

	//	Define the component properties using $props
	let {
		children,
		class: className,
		icon,
		options,
		placeholder = "Select one...",
		value = $bindable(),
        ...attrs
    } = $props()

	//	Declare a variable to hold the input element reference
    let input

	//	Export a function to focus the input element
    export function focus() {
        input?.focus()
    }

	//	Use onMount to focus the input element if autofocus is set
    onMount(() => {
        if (attrs.autofocus && input) {
            input.focus()
        }
    })

	//  Use $derived to create reactive variables for selected label and options
	let selectedLabel = $derived(
		value
		? options.find(option => option.value === value)?.label
		: placeholder
	)
	let selectOptions = $derived(
		options.map(option => ({
			label: option.label,
			value: option.value || option.label.toLowerCase(),
			disabled: option.disabled,
			...option
		}))
	)

</script>



<!-- STRUCTURE -->

<Select.Root class="select" type="single" items={options} {...attrs} bind:value={value}>

	<!-- The trigger element is what will be clicked to access the options -->
	<Select.Trigger class="style-input select-trigger {className}" aria-label={selectedLabel}>
		{#if icon}
			<Icon name={icon} class="text-slate-400" size={16} weight="bold" />
		{/if}
		<span class="text-left px-3 py-2 w-full">{selectedLabel}</span>
		<Button
			class="p-2"
			icon="CaretUpDown"
		/>
	</Select.Trigger>

	<!-- The content will appear when the trigger is clicked -->
	<Select.Portal class="w-full">
		<Select.Content class="select-content min-w-[var(--bits-select-anchor-width)]" position="popper" sideOffset={4}>

			<Select.ScrollUpButton class="flex w-full items-center justify-center opacity-50">
				<Icon name="CaretDoubleUp" size={12} />
			</Select.ScrollUpButton>

			<Select.Viewport>
				{#each selectOptions as option, i (i + option.value)}
					<Select.Item class="select-item" label={option.label} value={option.value} disabled={option.disabled}>
						{#snippet children({ selected })}
							{option.label}
							{#if selected}
								<div class="ml-auto">
								<Icon name="Check" />
								</div>
							{/if}
						{/snippet}
					</Select.Item>
				{/each}
			</Select.Viewport>

			<Select.ScrollDownButton class="flex w-full items-center justify-center opacity-50">
				<Icon name="CaretDoubleDown" size={12} />
			</Select.ScrollDownButton>

		</Select.Content>
	</Select.Portal>

</Select.Root>



<!-- STYLE -->

<style lang="postcss">

	:global(.select-trigger) {
		@apply flex gap-3 min-h-10 rounded-lg w-full;
		@apply focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2;
		
		&[data-placeholder] span {
			color: var(--text-placeholder);
			font-style: italic;
			opacity: 75%;
		}
	}

	:global(.select-content) {
		@apply block max-h-72 p-1 w-full ;
		@apply border rounded-lg shadow-2xl;
		background-color: var(--bg-white);
		border-color: var(--border-input);
		color: var(--text-input);

		:global(.select-item) {
			@apply flex items-center gap-3 px-3 py-2;
			@apply rounded cursor-pointer;
			&:hover {
				background-color: var(--background);
			}
			&[aria-selected] {
				color: var(--text-accent);
			}
		}
	}

</style>