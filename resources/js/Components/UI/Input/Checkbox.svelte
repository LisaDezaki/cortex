<!-- SCRIPT -->

<script>

	import { Checkbox } from "bits-ui";
	import Icon from '@/Components/UI/Icon.svelte';
	import Label from '@/Components/UI/Label.svelte';
    import clsx from "clsx"

	/**
	 * Component Props
	 * @type {Object}
	 * @property {boolean} checked  | Checkbox checked state
	 * @property {string} className | Additional class names
	 * @property {boolean} label    | Text to display beside checkbox
	 */
    let {
        checked = $bindable(false),
        class: className,
		label,
		labelText,
		size = 'md',
        ...restProps
    } = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		wrapper: clsx('flex items-center gap-3 min-h-10 py-2 cursor-pointer'),
		checkbox: clsx('appearance-none border-b min-h-6 min-w-6 rounded shrink-0 inline-flex items-center justify-center', {
			'bg-accent border-accent-strong text-white': checked,
			'bg-slate-50 border-neutral-softest': !checked
		}, className),
		label: clsx('text-neutral', `text-${size}`)
	})
	
</script>



<!-- STRUCTURE -->

<label
	id="{restProps.id}-label"
	for={restProps.id}
	class={cx.wrapper}
	disabled={restProps.disabled}
	required={restProps.required}
>
	<Checkbox.Root
		aria-labelledby="{restProps.id}-label"
		id={restProps.id}
		class={cx.checkbox}
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

	<span class={cx.text}>{labelText}</span>
</label>