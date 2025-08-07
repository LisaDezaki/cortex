<script>
    let {
		children,
		// checked = $bindable(false),
		class: className,
		description = null,
		errors,
		// inputClass,
		// inputType,
		label,
		layout,
		// multiple,
		// name,
		// options = [],
		required = false,
		type,
		value = $bindable(''),
        ...restProps
    } = $props()

	// import Checkbox from '@/Components/Form/Checkbox.svelte'
	// import Checkboxes from '@/Components/Form/Checkboxes.svelte'
	// import Combobox from '@/Components/Form/Combobox.svelte'
	import Error from '@/Components/Form/Error.svelte'
	import Input from '@/Components/Input.svelte'
	// import Input from '@/Components/Form/Input.svelte'
	import Label from '@/Components/Form/Label.svelte'
	// import Number from '@/Components/Form/Number.svelte'
    // import Radio from '@/Components/Form/Radio.svelte'
	// import Select from '@/Components/Form/Select.svelte'
	// import Slider from '@/Components/Form/Slider.svelte'
	// import Switch from '@/Components/Form/Switch.svelte'
	// import Textarea from '@/Components/Form/Textarea.svelte'
	// import Upload from '@/Components/Form/Upload.svelte'
</script>

{#snippet labelBlock()}
	<Label
		for={name}
		value={label}
		required={required}
	/>
{/snippet}

{#snippet descriptionBlock()}
	<div class="font-style-small text-slate-400">{description}</div>
{/snippet}

{#snippet inputBlock()}
	<Input {type} bind:value {...restProps} />
{/snippet}

{#snippet errorBlock()}
	<Error message={errors} />
{/snippet}

<div class="form-field {className} {layout}">

	{#if layout == 'block'}
		<div class="col-span-2">
			{@render labelBlock()}
			{@render descriptionBlock()}
		</div>
		<div class="col-span-3">
			{@render inputBlock()}
			{@render errorBlock()}
		</div>
	{:else}
		{@render labelBlock()}
		{@render inputBlock()}
		{@render errorBlock()}
		{@render descriptionBlock()}
	{/if}

	{@render children?.()}

	<!-- {#if type}
		<Input class="mt-0.5" {...restProps} />
	{/if}

	{#if layout == 'inline' && description}
		<p class="field-description">{description}</p>
	{/if}

	{#if errors}
		<Error message={errors} />
	{/if} -->

</div>

<style lang="postcss">

	.field-label {
		@apply mt-1.5 px-1.5 text-sm;
		color: var(--text-neutral-soft);
	}

	.form-field.block {
		@apply grid grid-cols-5 gap-6 w-full;
	}

	.form-field.inline {
		@apply flex flex-col items-center gap-3;
	}

	.field-description {
		@apply mt-1.5 px-1.5 text-sm;
		color: var(--text-neutral-soft);
	}

	.field-errors {
		@apply mt-1.5 px-1.5 text-sm;
		color: var(--text-neutral-soft);
	}

</style>