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
    import clsx from 'clsx'

	let {
		checked = $bindable(false),
		class: className,
		contentClass,
		name,
		options = [],
		size = "md",
		type = 'text',
		value = $bindable(''),
        ...restProps
    } = $props()

	const iconSizes = {
		xs: 12,
		sm: 14,
		md: 16,
		lg: 18,
		xl: 20,
	}

	// const hSizes = {
	// 	xs: "h-6",
	// 	sm: "h-7",
	// 	md: "h-8",
	// 	lg: "h-9",
	// 	xl: "h-10"
	// }

	// const padSizes = {
	// 	xs: "py-0",
	// 	sm: "py-0.25",
	// 	md: "py-0.5",
	// 	lg: "py-1",
	// 	xl: "py-1.5"
	// }

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		input:		clsx('input relative inline-flex items-center min-w-32 rounded', `p-${size}`, className),
		placeholder:clsx('input-placeholder italic opacity-75 text-neutral-softer'),
		icon:		clsx('input-icon absolute left-1 inline-flex items-center justify-center aspect-square h-7 -mr-1 rounded w-7'),
		value:		clsx('input-value bg-transparent border-none inline-flex items-center gap-2 line-clamp-1 rounded text-left text-sm w-full'),
		element:	clsx('input-element bg-transparent border-none h-full px-1 rounded-sm text-sm w-full focus:appearance-none'),
		action:		clsx('input-action aspect-square hover:bg-neutral-softest inline-flex items-center justify-center h-7 rounded shrink-0 w-7'),
		content:	clsx('input-content block border border-accent font-body max-h-96 min-w-32 overflow-y-auto rounded shadow-lg text-neutral z-10', contentClass),
		option:		clsx('input-option flex items-center cursor-pointer h-7 pl-1.5 pr-0.5 rounded-sm text-sm hover:bg-neutral-softest')
	})

</script>



{#if ['text', 'email', 'password', 'url', 'search', 'tel'].includes(type)}
	<Input id={name} bind:value={value}
		class={cx.input}
		type={type}
	{...restProps} />
{/if}


{#if type == 'textarea'}
	<Textarea id={name} bind:value={value}
		class={cx.input}
	{...restProps} />
{/if}


{#if type == 'number'}
	<Number id={name} bind:value={value}
		class={cx.input}
	{...restProps} />
{/if}


{#if type == 'select'}
	<Select id={name} bind:value={value}
		class={cx.input}
		options={options}
	{...restProps} />
{/if}


{#if type == 'combobox'}
	<Combobox id={name} bind:value={value}
		class="input {className}"
		options={options}
	{...restProps} />
{/if}


{#if type == 'slider'}
	<Slider id={name} bind:value={value}
		class={className}
	{...restProps} />
{/if}


{#if type == 'checkbox'}
	{#if options.length > 0}
		<Checkboxes id={name} bind:checked={checked}
			class={className}
			options={options}
		{...restProps} />
	{:else}
		<Checkbox id={name} bind:checked={checked}
			class={className}
		{...restProps} />
	{/if}
{/if}


{#if type == 'radio'}
	<Radio id={name} bind:checked={checked}
		class={className}
		options={options}
	{...restProps} />
{/if}


{#if type == 'switch'}
	<Switch id={name} bind:checked={checked}
		class={className}
	{...restProps} />
{/if}


{#if type == 'file'}
	<Upload id={name} bind:value={value}
		class="input {className}"
	{...restProps} />
{/if}





<style lang="postcss">

	:global(.input:not([class*="max-w-"])) {
		@apply max-w-96;
	}

	:global(.input)::placeholder,
	:global(input::placeholder),
	:global(.input-placeholder) {
		color: var(--text-neutral-softer);
		font-style: italic;
		opacity: 75%;
	}

	:global(.input) {
		@apply relative inline-flex items-center min-w-32 rounded;
		@apply border-b;
		background-color: var(--bg-input);
		/* border: none; */
		border-color: var(--border-neutral-softest);
		color: var(--text-input);
		/* box-shadow: 0 1px 0 var(--shadow-lowlight); */

		&.input-slider {
			@apply min-h-4;
		}

		&.pl-icon {
			@apply pl-8;
		}

		&::placeholder,
		:global(input::placeholder),
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
		}

		:global(.input-value) {
			@apply bg-transparent border-none inline-flex items-center gap-2 line-clamp-1 rounded text-left text-sm w-full;
			&.pl-icon {
				@apply pl-8;
			}
		}

		:global(input),
		:global(.input-element) {
			@apply bg-transparent border-none h-full px-1 rounded-sm text-sm w-full focus:appearance-none;
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
		@apply block max-h-96 min-w-32 overflow-y-auto z-10;
		@apply border rounded shadow-lg;
		background-color: var(--bg-input);
		border-color: var(--border-accent);
		color: var(--text-neutral);
		font-family: Archivo, Figtree, ui-sans-serif, system-ui, sans-serif;

		:global(.input-option) {
			@apply flex items-center h-7 pl-1.5 pr-0.5 rounded-sm text-sm;
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