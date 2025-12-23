<script>
	import Checkbox   from '@/Components/UI/Input/Checkbox.svelte'
	// import Checkboxes from '@/Components/UI/Input/Checkboxes.svelte'
	// import Combobox   from '@/Components/UI/Input/Combobox.svelte'
	import Text       from '@/Components/UI/Input/Text.svelte'
	import Number     from '@/Components/UI/Input/Number.svelte'
	import Option     from '@/Components/UI/Input/Option.svelte'
    import Radio      from '@/Components/UI/Input/Radio.svelte'
	import Select     from '@/Components/UI/Input/Select.svelte'
	import Slider     from '@/Components/UI/Input/Slider.svelte'
	import Switch     from '@/Components/UI/Input/Switch.svelte'
	import Textarea   from '@/Components/UI/Input/Textarea.svelte'
	import Upload     from '@/Components/UI/Input/Upload.svelte'
    import clsx from 'clsx'

	let {
		checked = $bindable(false),
		children,
		class: className,
		contentClass,
		name,
		options = [],
		type = 'text',
		value = $bindable(''),
        ...restProps
    } = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		input:		clsx('input relative inline-flex items-center min-w-[32ch] rounded', className),
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
	<Text id={name} bind:value={value}
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


{#if type == 'slider'}
	<Slider id={name} bind:value={value}
		class={className}
	{...restProps} />
{/if}


{#if type == 'checkbox'}
	<Checkbox id={name} bind:checked={checked}
		class={className}
	{...restProps} />
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

{@render children?.()}





<style lang="postcss">

	/*	Placeholder  */

	:global(.input)::placeholder,
	:global(input::placeholder),
	:global(.input-placeholder) {
		color: var(--text-neutral-softer);
		font-style: italic;
	}

	:global(.input) {
		@apply relative inline-flex items-center min-w-[12ch] rounded;
		@apply border-b;
		background-color: var(--bg-input);
		border-color: var(--border-neutral-softest);
		color: var(--text-input);

		&.input-slider {
			@apply min-h-4;
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
			@apply inline-flex items-center justify-center aspect-square rounded;
		}

		:global(.input-value) {
			@apply bg-transparent border-none inline-flex items-center gap-2 line-clamp-1 rounded text-left w-full;
		}

		:global(input),
		:global(.input-element) {
			@apply bg-transparent border-none h-full px-1 rounded-sm w-full focus:appearance-none;
			-moz-appearance: textfield;
			&:outer-spin-button,
			&:inner-spin-button {
				-webkit-appearance: none;
				appearance: none;
				margin: 0;
			}
		}

		:global(.input-action) {
			@apply inline-flex items-center justify-center flex-shrink-0 aspect-square rounded;
			&:hover {
				background-color: var(--bg-neutral-softest);
			}

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
			@apply flex items-center rounded-sm;
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