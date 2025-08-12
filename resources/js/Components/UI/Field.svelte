<script>
    let {
		children,
		// checked = $bindable(false),
		class: className,
		description = null,
		errors,
		inputClass,
		// inputType,
		label,
		labelSrOnly = false,
		layout,
		// multiple,
		name,
		// options = [],
		required = false,
		type,
		value = $bindable(''),
        ...restProps
    } = $props()

	import Error from '@/Components/UI/Form/Error.svelte'
	import Input from '@/Components/UI/Input.svelte'
	import Label from '@/Components/UI/Form/Label.svelte'
</script>

{#snippet labelBlock()}
	<Label
		for={name}
		value={label}
		required={required}
		class="field-label {labelSrOnly ? 'sr-only' : ''}"
	/>
{/snippet}

{#snippet descriptionBlock()}
	<div class="font-style-small text-slate-400">{description}</div>
{/snippet}

{#snippet inputBlock()}
	{#if type}
		<Input class="{inputClass} my-1" name={name} {type} bind:value {...restProps} />
	{/if}
{/snippet}

{#snippet errorBlock()}
	<Error message={errors} />
{/snippet}

<div class="form-field {className} {layout}">

	{#if layout == 'block'}
		<div class="col-span-1">
			{@render labelBlock()}
			{@render descriptionBlock()}
		</div>
		<div class="col-span-1">
			{@render inputBlock()}
			{@render errorBlock()}
		</div>
	{:else}
		{@render labelBlock()}
		{@render descriptionBlock()}
		{@render inputBlock()}
		{@render errorBlock()}
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
		@apply mt-1 px-1.5 text-sm;
		color: var(--text-neutral-soft);
	}

	.form-field.block {
		@apply grid grid-cols-2 gap-6 w-full mb-3;
	}

	.form-field:not(.block) {
		@apply flex flex-col items-stretch mb-3;
	}

	.field-description {
		@apply mt-1 px-1.5 text-sm;
		color: var(--text-neutral-soft);
	}

	.field-errors {
		@apply mt-1 px-1.5 text-sm;
		color: var(--text-neutral-soft);
	}

</style>