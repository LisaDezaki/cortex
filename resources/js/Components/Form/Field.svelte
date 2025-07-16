<script>
    let {
		children,
		checked = $bindable(false),
		class: className,
		description = null,
		errors,
		label,
		layout,
		name,
		options = [],
		required = false,
		type,
		value = $bindable(''),
        ...attrs
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

	<div class="col-span-1">

		{#if ['text', 'email', 'password', 'url', 'search', 'tel'].includes(type)}
			<Input
				id={name}
				bind:value={value}
				type={type}
				{...attrs}
			/>
		{/if}
	
		{#if type == 'textarea'}
			<Textarea
				id={name}
				bind:value={value}
				{...attrs}
			/>
		{/if}
	
		{#if type == 'number'}
			<Number
				id={name}
				bind:value={value}
				{...attrs}
			/>
		{/if}
	
		{#if type == 'slider'}
			<Slider
				id={name}
				bind:value={value}
				{...attrs}
			/>
		{/if}
	
		{#if type == 'select'}
			<Select
				id={name}
				bind:value={value}
				options={options}
				{...attrs}
			/>
		{/if}
	
		{#if type == 'combobox'}
			<Combobox
				id={name}
				bind:value={value}
				options={options}
				{...attrs}
			/>
		{/if}
	
		{#if type == 'checkbox'}
			{#if options.length > 0}
				<Checkboxes
					id={name}
					bind:checked={checked}
					options={options}
					{...attrs}
				/>
			{:else}
				<Checkbox
					id={name}
					bind:checked={checked}
					{...attrs}
				/>
			{/if}
		{/if}
	
		{#if type == 'radio'}
			<Radio
				id={name}
				bind:checked={checked}
				options={options}
				{...attrs}
			/>
		{/if}
	
		{#if type == 'switch'}
			<Switch
				id={name}
				bind:checked={checked}
				label={label}
				{...attrs}
			/>
		{/if}
	
		{#if type == 'file'}
			<Upload
				id={name}
				bind:value={value}
				label={label}
				{...attrs}
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
		@apply grid grid-cols-2 gap-4 w-full;
	}

	.form-field.inline {
		@apply flex flex-col items-center gap-4;
	}

</style>