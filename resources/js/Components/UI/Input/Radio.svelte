<script>
	import { RadioGroup } from "bits-ui";
	import Label from '@/Components/UI/Label.svelte'

	let {
		checked = $bindable(),
		class: className,
		options,
		size = 'md',
		...restProps
	} = $props();

	function valueChange(value) {
		checked = value;
	}

	let cx = {
		disabled: 'pointer-events-none cursor-not-allowed text-neutral-softer'
	}

</script>



{#snippet radioItem(option)}
	<label
		id="{option.id}-label"
		for={option.id}
		class="radio-label {className} {option.disabled ? cx.disabled : ''}"
		description={option.description}
		disabled={option.disabled}
		required={option.required}
	>
		<RadioGroup.Item
			aria-labelledby="{option.id}-label"
			id={option.value}
			value={option.value}
			class="radio"
			disabled={option.disabled}
		{...option}>
			<div class="dot"></div>
		</RadioGroup.Item>

		<span class="text-{size}">{option.label}</span>
	</label>
{/snippet}

<RadioGroup.Root class="input-radio" value={checked} onValueChange={valueChange} {...restProps}>
	{#each options as option}
		{@render radioItem(option)}
	{/each}
</RadioGroup.Root>

<style lang="postcss">

	:global(.input-radio) {
		@apply flex flex-col;

		:global(.radio-label) {
			@apply flex items-center gap-3 min-h-10 py-2 cursor-pointer;
			&[disabled="true"] {
				cursor: not-allowed;
				opacity: 50%;
				pointer-events: none;
			}

			:global(.radio) {
				@apply appearance-none min-h-6 min-w-6 rounded-full flex-shrink-0;
				@apply inline-flex items-center justify-center;
				background-color: var(--bg-input);
				border-bottom: 1px solid var(--border-neutral-softer);

				&[data-state="checked"] {
					background: var(--bg-accent-gradient);
					border-bottom: 1px solid var(--border-accent-strong);
					color: var(--text-white);
				}
			}
		}
	}

	:global(.radio .dot) {
		@apply h-4 w-4 rounded-full transition-all duration-300 ease-in-out;
	}

	:global(.radio[data-state="checked"] .dot) {
		@apply bg-white h-2 w-2;
	}

</style>