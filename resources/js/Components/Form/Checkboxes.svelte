<script>

	import { Checkbox, useId } from "bits-ui";
	import Check from './Checkbox.svelte';
	import Icon from '@/Components/Icon.svelte';

	let {
		checked = $bindable(),
		class: className,
		label,
		options
	} = $props()

	function valueChange(value) {
		checked = value;
	}
	
</script>

<Checkbox.Group bind:value={checked} onValueChange={valueChange}>
	{#each options as option}
		{@render MyCheckbox(option)}
	{/each}
</Checkbox.Group>

{#snippet MyCheckbox(option)}
	{@const id = useId()}
	<Check
		{id}
		class="checkboxes-checkbox"
		labelText={option.label}
		value={option.value}
		{...option}
	/>
{/snippet}

<style lang="postcss">

	:global(.checkboxes-checkbox) {
		@apply rounded-none;
		&:first-of-type {
			@apply rounded-tl-lg rounded-tr-lg;
		}
		&:last-of-type {
			@apply rounded-bl-lg rounded-br-lg;
		}
	}

	:global(.checkboxes-checkbox:not(:first-of-type)) {
		@apply mt-[-1px];
	}

</style>