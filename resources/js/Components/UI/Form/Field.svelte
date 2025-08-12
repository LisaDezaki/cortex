<!-- <script>
    let {
		children,
		checked = $bindable(false),
		class: className,
		description = null,
		errors,
		inputClass,
		inputType,
		label,
		layout,
		multiple,
		name,
		options = [],
		required = false,
		type,
		value = $bindable(''),
        ...restProps
    } = $props()

	import Checkbox from './Checkbox.svelte'
	import Checkboxes from './Checkboxes.svelte'
	import Combobox from './Combobox.svelte'
	import Error from './Error.svelte'
	import Input from './Input.svelte'
	import Label from './Label.svelte'
	import Number from './Number.svelte'
    import Radio from './Radio.svelte'
	import Select from './Select.svelte'
	import Slider from './Slider.svelte'
	import Switch from './Switch.svelte'
	import Textarea from './Textarea.svelte'
	import Upload from './Upload.svelte'
</script>

<div class="form-field {className} {layout}">

	{#if layout == 'block'}
		<div class="col-span-1">
			<Label
				for={name}
				value={label}
				required={required}
			/>
			<div class="font-style-small text-slate-400">{description}</div>
		</div>
	{:else}
		{#if label || description}
			<Label
				class="mb-0.5"
				for={name}
				value={label}
				description={description}
				required={required}
			/>
		{/if}
	{/if}

	<div class="col-span-2">

		{#if ['text', 'email', 'password', 'url', 'search', 'tel'].includes(inputType)}
			<Input
				id={name}
				bind:value={value}
				class={inputClass}
				type={type}
				{...restProps}
			/>
		{/if}
	
		{#if inputType == 'textarea'}
			<Textarea
				id={name}
				bind:value={value}
				class={inputClass}
				{...restProps}
			/>
		{/if}
	
		{#if inputType == 'number'}
			<Number
				id={name}
				bind:value={value}
				class={inputClass}
				{...restProps}
			/>
		{/if}
	
		{#if inputType == 'slider'}
			<Slider
				id={name}
				bind:value={value}
				class={inputClass}
				{...restProps}
			/>
		{/if}
	
		{#if inputType == 'select'}
			<Select
				id={name}
				bind:value={value}
				class={inputClass}
				options={options}
				{...restProps}
			/>
		{/if}
	
		{#if inputType == 'combobox'}
			<Combobox
				id={name}
				bind:value={value}
				class={inputClass}
				options={options}
				{...restProps}
			/>
		{/if}
	
		{#if inputType == 'checkbox'}
			{#if options.length > 0}
				<Checkboxes
					id={name}
					bind:checked={checked}
					class={inputClass}
					options={options}
					{...restProps}
				/>
			{:else}
				<Checkbox
					id={name}
					bind:checked={checked}
					class={inputClass}
					{...restProps}
				/>
			{/if}
		{/if}
	
		{#if inputType == 'radio'}
			<Radio
				id={name}
				bind:checked={checked}
				class={inputClass}
				options={options}
				{...restProps}
			/>
		{/if}
	
		{#if inputType == 'switch'}
			<Switch
				id={name}
				bind:checked={checked}
				class={inputClass}
				label={label}
				{...restProps}
			/>
		{/if}
	
		{#if inputType == 'file'}
			<Upload
				id={name}
				bind:value={value}
				class={inputClass}
				label={label}
				{...restProps}
			/>
		{/if}

	</div>

	{#if children}
		{@render children()}
	{/if}

	{#if errors}
		<Error message={errors} />
	{/if}

</div>

<style lang="postcss">
	.form-field.block {
		@apply grid grid-cols-3 gap-6 w-full;
	}

	.form-field.inline {
		@apply flex flex-col items-center gap-3;
	}

</style> -->