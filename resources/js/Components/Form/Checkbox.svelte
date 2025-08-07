<!-- SCRIPT -->

<script>

	import { Checkbox } from "bits-ui";
	import Icon from '@/Components/Icon.svelte';
	import Label from './Label.svelte';

    let {
        checked = $bindable(false),
        class: className,
		label,
		labelText,
        ...restProps
    } = $props()
	
</script>



<!-- STRUCTURE -->

<Label
	id="{restProps.id}-label"
	for={restProps.id}
	class="checkbox-label {className}"
	description={restProps.description}
	disabled={restProps.disabled}
	required={restProps.required}
>
	<Checkbox.Root
		aria-labelledby="{restProps.id}-label"
		id={restProps.id}
		class="checkbox"
		bind:checked
		disabled={restProps.disabled}
	{...restProps}>
		{#snippet children({ checked, indeterminate })}
			{#if indeterminate}
				<Icon name="Minus" size={20} weight="bold" />
			{:else if checked}
				<Icon name="Check" size={20} weight="bold" />
			{/if}
		{/snippet}
	</Checkbox.Root>

	<span class="font-style-regular">{labelText}</span>
</Label>



<!-- STYLE -->

<style lang="postcss">

	:global(.checkbox-label) {
		/* outline: 1px solid red;
		outline-offset: -1px; */
		@apply flex items-start gap-3 min-h-10 py-2 cursor-pointer;
		&[disabled="true"] {
			cursor: not-allowed;
			opacity: 50%;
			pointer-events: none;
		}

		:global(.checkbox) {
			@apply appearance-none min-h-6 min-w-6 rounded-md flex-shrink-0;
			@apply inline-flex items-center justify-center;
			background-color: var(--bg-input);
			box-shadow: 0 1px 0 var(--shadow-lowlight);

			&[data-state="checked"],
			&[data-state="indeterminate"] {
				background: var(--bg-accent-gradient);
				border: 1px solid var(--border-accent-strong);
				color: var(--text-white);
			}
		}
	}

</style>