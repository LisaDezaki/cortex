<script>
	import Checkbox   from '@/Components/UI/Inputs/Checkbox.svelte'
	import Checkboxes from '@/Components/UI/Inputs/Checkboxes.svelte'
	import Combobox   from '@/Components/UI/Inputs/Combobox.svelte'
	import Input      from '@/Components/UI/Inputs/Input.svelte'
	import Number     from '@/Components/UI/Inputs/Number.svelte'
    import Radio      from '@/Components/UI/Inputs/Radio.svelte'
	import Select     from '@/Components/UI/Inputs/Select.svelte'
	import Slider     from '@/Components/UI/Inputs/Slider.svelte'
	import Switch     from '@/Components/UI/Inputs/Switch.svelte'
	import Textarea   from '@/Components/UI/Inputs/Textarea.svelte'
	import Upload     from '@/Components/UI/Inputs/Upload.svelte'

	let {
		checked = $bindable(false),
		class: className,
		label,
		name,
		options = [],
		type = 'text',
		value = $bindable(''),
        ...restProps
    } = $props()
	
</script>





{#if ['text', 'email', 'password', 'url', 'search', 'tel'].includes(type)}
	<Input
		id={name}
		class="input {className}"
		bind:value={value}
		type={type}
		{...restProps}
	/>
{/if}

{#if type == 'textarea'}
	<Textarea
		id={name}
		class="input {className}"
		bind:value={value}
		{...restProps}
	/>
{/if}

{#if type == 'number'}
	<Number
		id={name}
		class="input {className}"
		bind:value={value}
		{...restProps}
	/>
{/if}

{#if type == 'select'}
	<Select
		id={name}
		class="input {className}"
		contentClass="input-content"
		options={options}
		bind:value={value}
		{...restProps}
	/>
{/if}

{#if type == 'combobox'}
	<Combobox
		id={name}
		class="input {className}"
		contentClass="input-content"
		options={options}
		bind:value={value}
		{...restProps}
	/>
{/if}

{#if type == 'slider'}
	<Slider
		id={name}
		class={className}
		bind:value={value}
		{...restProps}
	/>
{/if}

{#if type == 'checkbox'}
	{#if options.length > 0}
		<Checkboxes
			id={name}
			class={className}
			options={options}
			bind:checked={checked}
			{...restProps}
		/>
	{:else}
		<Checkbox
			id={name}
			class={className}
			bind:checked={checked}
			{...restProps}
		/>
	{/if}
{/if}

{#if type == 'radio'}
	<Radio
		id={name}
		class={className}
		bind:checked={checked}
		options={options}
		{...restProps}
	/>
{/if}

{#if type == 'switch'}
	<Switch
		id={name}
		class={className}
		bind:checked={checked}
		label={label}
		{...restProps}
	/>
{/if}

{#if type == 'file'}
	<Upload
		id={name}
		bind:value={value}
		class="input {className}"
		{...restProps}
	/>
{/if}





<style lang="postcss">

	:global(.input:not([class*="w-"])) {
		@apply w-full;
	}

	:global(.input) {
		@apply relative inline-flex items-center min-h-10 p-1 rounded-lg;
		background-color: var(--bg-input);
		border: none;
		color: var(--text-input);
		box-shadow: 0 1px 0 var(--shadow-lowlight);

		&.input-slider {
			@apply min-h-4;
		}


		&::placeholder,
		:global(input::placeholder),
		&[data-placeholder] .input-value,
		:global(.input-placeholder) {
			color: var(--text-neutral-softer);
			font-style: italic;
			opacity: 75%;
		}
		&[data-state="open"],
		&.focus {
			box-shadow: 0 1px 0 var(--bg-accent);
			color: var(--text-accent);
			outline: 1px solid var(--border-accent);
			outline-offset: -1px;
		}
		&.disabled,
		&[aria-disabled],
		:global([aria-disabled]) {
			opacity: 50%;
			cursor: not-allowed;

			:global(*) {
				pointer-events: none;
			}
		}

		:global(.input-icon) {
			@apply inline-flex items-center justify-center h-7 w-7 -mr-1 aspect-square rounded;
			@apply absolute left-1;
			/* outline: 1px solid red;
			outline-offset: -1px; */
		}
		
		:global(.input-value) {
			@apply bg-transparent border-none inline-flex items-center gap-2 line-clamp-1 pl-2 rounded text-left w-full;
			&.pl-icon {
				@apply pl-8;
			}
		}

		:global(input),
		:global(.input-element) {
			@apply bg-transparent border-none h-full px-2 py-1 rounded w-full focus:appearance-none;
			-moz-appearance: textfield;
			&:outer-spin-button,
			&:inner-spin-button {
				-webkit-appearance: none;
				appearance: none;
				margin: 0;
			}
			&.pl-icon {
				@apply pl-8;
			}
			/* outline: 1px solid yellow;
			outline-offset: -1px; */
		}

		:global(.input-action) {
			@apply inline-flex items-center justify-center flex-shrink-0 h-7 w-7 aspect-square rounded;
			&:hover {
				background-color: var(--bg-neutral-softest);
			}
			/* outline: 1px solid lime;
			outline-offset: -1px; */

			&.disabled {
				background-color: var(--bg-disabled);
				border-color: var(--border-disabled);
				color: var(--text-disabled);
				cursor: not-allowed;
			}
		}
	}

	:global(.input-content) {
		@apply block max-h-96 overflow-y-auto py-1 z-10;
		@apply border rounded-lg shadow-lg;
		background-color: var(--bg-input);
		border-color: var(--border-accent);
		color: var(--text-neutral);
		font-family: Archivo, Figtree, ui-sans-serif, system-ui, sans-serif;

		:global(.input-option) {
			@apply flex items-center gap-2 px-3 py-1.5;
			@apply cursor-pointer;
			&:hover,
			&[data-highlighted] {
				background-color: var(--bg-neutral-softest);
			}
			&[aria-selected],
			&.active {
				color: var(--text-accent);
			}
		}
	}

</style>