<script>
	import { RadioGroup } from "bits-ui";
	import Label from './Label.svelte'

	let {
		checked = $bindable(),
		class: className,
		options,
		...attrs
	} = $props();

	function valueChange(value) {
		checked = value;
	}
</script>

<RadioGroup.Root class="form-radio" value={checked} onValueChange={valueChange} {...attrs}>
	{#each options as option}
		<div class="radio-option" class:disabled={option.disabled}>
			<RadioGroup.Item id={option.value} value={option.value} class="radio" disabled={option.disabled}><div class="dot"></div></RadioGroup.Item>
			<Label inline for={option.value} class="inline-label cursor-pointer" disabled={option.disabled}>{option.label || option.value}</Label>
		</div>
	{/each}
</RadioGroup.Root>

<style lang="postcss">

	:global(.form-radio) {
		@apply relative flex flex-col bg-transparent border-none h-auto w-full;
	}

	.radio-option {
		@apply flex items-center gap-3 bg-transparent min-h-11 px-2 w-full;
		@apply border;
		@apply rounded-none;
		border-color: var(--border-soft);
		color: var(--text-input);
		&:hover {
			border-color: var(--border-input);
		}
		&:first-of-type {
			@apply rounded-tl-lg rounded-tr-lg;
		}
		&:last-of-type {
			@apply rounded-bl-lg rounded-br-lg;
		}
		&:not(:first-of-type) {
			@apply mt-[-1px];
		}
		&.disabled {
			@apply cursor-not-allowed;
			color: var(--text-disabled);
		}
	}

	:global(.radio) {
		@apply appearance-none min-h-6 min-w-6 border inline-flex items-center justify-center rounded-full flex-shrink-0;
		&:not([data-state="checked"]) {
			background-color: var(--bg-input);
			border-color: var(--border-input);
			color: var(--text-input);
		}
		&[data-state="checked"] {
			background: var(--gradient-primary);
			border-color: var(--border-primary);
			color: var(--text-white);
		}
		&[data-disabled] {
			background-color: var(--bg-disabled);
			border-color: var(--border-disabled);
			color: var(--text-disabled);
		}
	}

	:global(.radio .dot) {
		@apply bg-transparent h-0 w-0 rounded-full transition-all duration-200 ease-in-out;
	}

	:global(.radio-option.disabled .radio),
	:global(.radio-option.disabled .inline-label) {
		@apply cursor-not-allowed;
	}

	:global(.radio[data-state="checked"] .dot) {
		@apply bg-white h-2 w-2;
	}

</style>