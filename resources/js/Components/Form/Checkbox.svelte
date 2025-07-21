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
        ...attrs
    } = $props()
	
</script>



<!-- STRUCTURE -->

<Label
	id="{attrs.id}-label"
	for={attrs.id}
	class="form-checkbox {className}"
	description={attrs.description}
	disabled={attrs.disabled}
	required={attrs.required}
>
	<Checkbox.Root
		aria-labelledby="{attrs.id}-label"
		class="checkbox"
		bind:checked
		{...attrs}
	>
		{#snippet children({ checked, indeterminate })}
			{#if indeterminate}
				<Icon name="Minus" size={20} weight="bold" />
			{:else if checked}
				<Icon name="Check" size={20} weight="bold" />
			{/if}
		{/snippet}

	</Checkbox.Root>

	<span class="checkbox-label">{labelText}</span>

</Label>



<!-- STYLE -->

<style lang="postcss">

	:global(.form-checkbox) {
		@apply border-none flex items-center gap-3 min-h-11 p-2 w-full;
		/* @apply border-inherit; */
		@apply rounded-lg;
		background-color: transparent;
		/* border-color: var(--border-neutral-soft); */
		color: var(--text-input);
		/* &:hover {
			border-color: var(--border-input);
		} */
	}

	:global(.form-checkbox.disabled) {
		@apply cursor-not-allowed;
		color: var(--text-disabled);
	}

	:global(.checkbox) {
		@apply flex items-center justify-center min-h-7 min-w-7;
		@apply border rounded-lg;
		background-color: var(--bg-neutral-soft);
		border-color: var(--border-neutral-soft);
		color: var(--text-input);
		&:hover {
			background-color: var(--bg-neutral-soft-hover);
			border-color: var(--border-neutral-soft-hover);
		}
	}
	:global(.checkbox[data-state="checked"]),
	:global(.checkbox[data-state="indeterminate"]) {
		background: var(--bg-accent-gradient);
		border-color: var(--border-accent);
		color: var(--text-white);
	}

	:global(.checkbox[data-disabled]) {
		opacity: 50%;
		pointer-events: none;
	}

	.checkbox-label {
		@apply text-base w-full;
	}

</style>