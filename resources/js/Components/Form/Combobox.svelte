<!-- SCRIPT -->

<script>

	import { Combobox } from "bits-ui";
	import Icon from '@/Components/Icon.svelte'

	let {
		children,
		class: className,
		icon,
		options,
		placeholder = "Select one...",
		value = $bindable(),
        ...attrs
    } = $props()

	let query = $state('')

	// let selectedLabel = $derived(
	// 	value
	// 	? options.find(option => option.value === value)?.label
	// 	: placeholder
	// )

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
		console.log(index)
		value = value.filter((_, i) => i !== index)
	}

	const fruits = [
		{ value: "mango", label: "Mango" },
		{ value: "watermelon", label: "Watermelon" },
		{ value: "apple", label: "Apple" },
		{ value: "pineapple", label: "Pineapple" },
		{ value: "orange", label: "Orange" },
		{ value: "grape", label: "Grape" },
		{ value: "strawberry", label: "Strawberry" },
		{ value: "banana", label: "Banana" },
		{ value: "kiwi", label: "Kiwi" },
		{ value: "peach", label: "Peach" },
		{ value: "cherry", label: "Cherry" },
		{ value: "blueberry", label: "Blueberry" },
		{ value: "raspberry", label: "Raspberry" },
		{ value: "blackberry", label: "Blackberry" },
		{ value: "plum", label: "Plum" },
		{ value: "apricot", label: "Apricot" },
		{ value: "pear", label: "Pear" },
		{ value: "grapefruit", label: "Grapefruit" }
	];

	let searchValue = $state("");

	const filteredFruits = $derived(
		searchValue === ""
			? fruits
			: fruits.filter((fruit) =>
				fruit.label.toLowerCase().includes(searchValue.toLowerCase())
				)
	);

	// function handleInput(e) {
	// 	query = e.currentTarget.value;
	// }

	// let selectOptions = $derived(
	// 	options.map(option => ({
	// 		label: option.label,
	// 		value: option.value || option.label.toLowerCase(),
	// 		disabled: option.disabled,
	// 		...option
	// 	}))
	// )

</script>



<!-- STRUCTURE -->

<Combobox.Root
	type="multiple"
	name="favoriteFruit"
	onOpenChange={(o) => {
		if (!o) query = '';
	}}
	bind:value={value}
>
	<div class="combobox">
		<Combobox.Input class="combobox-input" />
		<div class="combobox-selection">
			{#each sortedValues as item,i}
				<button class="combobox-selected-item" onclick={() => removeItem(i)} type="button">{item}</button>
			{/each}
			<input
				oninput={(e) => (query = e.currentTarget.value)}
				class="combo-input"
				placeholder={placeholder}
				aria-label={placeholder}
				bind:value={query}
			/>
		</div>
		<Combobox.Trigger class="combobox-trigger">
			<Icon name="CaretUpDown" class="select-action text-slate-400 ml-auto border-l" size={16} weight="bold" />
		</Combobox.Trigger>
	</div>

	<Combobox.Portal>
		<Combobox.Content
			class="combobox-content max-h-[var(--bits-combobox-content-available-height)] w-[var(--bits-combobox-anchor-width)] min-w-[var(--bits-combobox-anchor-width)]"
			sideOffset={1}
		>
			<Combobox.ScrollUpButton class="flex w-full items-center justify-center">
				<Icon name="CaretDoubleUp" size={12} />
			</Combobox.ScrollUpButton>

			<Combobox.Viewport class="p-1">
				{#each filteredOptions as option, i (i + option.value)}
					<Combobox.Item
						class="combobox-item rounded-button data-highlighted:bg-muted outline-hidden flex h-10 w-full select-none items-center py-3 pl-5 pr-1.5 text-sm capitalize"
						value={option.value}
						label={option.label}
					>
						{#snippet children({ selected })}
							{option.label}
							{#if selected}
								<div class="ml-auto">
									<Icon name="Check" />
								</div>
							{/if}
						{/snippet}
					</Combobox.Item>
				{:else}
					<span class="block px-5 py-2 text-sm text-muted-foreground">
						No results found, try again.
					</span>
				{/each}
			</Combobox.Viewport>

			<Combobox.ScrollDownButton class="flex w-full items-center justify-center">
				<Icon name="CaretDoubleDown" size={12} />
			</Combobox.ScrollDownButton>

		</Combobox.Content>
	</Combobox.Portal>
</Combobox.Root>



<!-- STYLE -->

<style lang="postcss">

	:global(.combobox) {
		@apply relative flex w-full;
		@apply border rounded-lg;
		background-color: var(--bg-input);
		border-color: var(--border-soft);
		color: var(--text-input);
		&:hover {
			border-color: var(--border-input);
		}
	}

	:global(.combobox-input) {
		@apply absolute inset-0 opacity-0 pointer-events-none;
	}

	:global(.combobox-trigger) {
		@apply flex-shrink;
	}

	.combobox-selection {
		@apply flex-grow inline-flex flex-wrap items-start justify-start gap-0.5 p-0.5 w-full;
	}

	.combobox-selected-item {
		@apply inline-flex items-center justify-center min-h-10 px-2 py-1 text-sm;
		@apply border rounded-md cursor-no-drop bg-slate-100 hover:bg-slate-200;
		background: var(--input-hover);
		color: var(--text-input);
		
		/* &:hover {
			background: var(--gradient-secondary-alt);
			border-color: var(--border-input);
		} */
	}

	.combo-input {
		@apply bg-transparent border-none rounded-lg px-3 py-2;
		@apply focus:text-emerald-500 focus:border-emerald-500 focus:ring-emerald-500;
		&::placeholder {
			@apply italic;
			color: var(--text-placeholder);
		}
	}

	:global(.combobox-trigger) {
		@apply inline-flex items-stretch min-h-11;
		@apply focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2;
		background-color: var(--bg-input);
		border-color: var(--border-soft);
		color: var(--text-input);
		&:hover {
			border-color: var(--border-input);
		}
	}

	:global(.combobox-trigger[data-placeholder]) {
		@apply italic;
		color: var(--text-placeholder);
	}

	:global(.combobox-content) {
		@apply select-none rounded-xl border px-1 py-3;
		@apply block max-h-96 p-1 w-full;
		@apply border rounded-lg;
		@apply bg-slate-950 border-emerald-500 text-white;
		@apply focus:text-emerald-500 focus:border-emerald-500 focus:ring-emerald-500;
		background-color: var(--bg-input);
		border-color: var(--border-input);
		color: var(--text-input);
	}

	

	.combobox-label {
		@apply text-left px-3 py-2 w-full;
	}

	:global(.select-action) {
		@apply p-2;
	}

	:global(.combobox-item) {
		@apply flex items-center gap-3 px-3 py-2;
		@apply rounded cursor-pointer;
		&:hover {
			background-color: var(--background);
		}
		&[aria-selected] {
			color: var(--text-accent);
		}
	}

</style>