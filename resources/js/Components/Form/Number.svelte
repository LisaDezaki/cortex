<!-- SCRIPT -->

<script>

	//	Import onMount from Svelte to handle component lifecycle
    import { onMount } from 'svelte'

	//  Import Components to use within this component
	import Button from '@/Components/Button.svelte'

	//	Define the component properties using $props
    let {
        class: className,
        value = $bindable(),
        ...attrs
    } = $props()

	//	Declare a variable to hold the input element reference
    let input

	//	Export a function to focus the input element
    export function focus() {
        input?.focus()
    }

	//	Use onMount to focus the input element if autofocus is set
    onMount(() => {
        if (attrs.autofocus && input) {
            input.focus()
        }
    })

	//	Use $state to create a reactive state for the step value
	let step = $state( Number(attrs.step) || 1 )

	//	Functions to increment and decrement the value by the specified step amount (default 1), ensuring it stays within min and max bounds
	function decrement() {
		if (attrs.min && Number(attrs.min) > Number(value) - step) { return }
		value = Number(value) - step
	}
	function increment() {
		if (attrs.max && Number(attrs.max) < Number(value) + step) { return }
		value = Number(value) + step
	}

</script>



<!-- STRUCTURE -->

<div class="form-number style-input">

	<input type="number"
		{...attrs}
		aria-disabled={attrs.disabled ? 'true' : undefined}
		class="{className}"
		bind:value
		bind:this={input}
	/>

	<Button
		class="form-number-button left-1"
		disabled={value - step < attrs.min}
		icon="Minus"
		onclick={decrement}
	/>

	<Button
		class="form-number-button right-1"
		disabled={value + step > attrs.max}
		icon="Plus"
		onclick={increment}
	/>

</div>



<!-- STYLE -->

<style lang="postcss">

	.form-number {
		@apply relative flex items-center min-h-10 rounded-lg w-full;

		:global(.form-number-button) {
			@apply absolute border flex-shrink-0 rounded-md w-8;
			@apply bg-slate-100 hover:bg-slate-300 border-slate-200 text-emerald-500;

			&.disabled {
				background-color: var(--bg-disabled);
				border-color: var(--border-disabled);
				color: var(--text-disabled);
				cursor: not-allowed;
			}
		}

		input {
			@apply bg-inherit border-none;
			@apply px-11 rounded-lg w-full;
			@apply focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2;

			&::placeholder {
				color: var(--text-placeholder);
				font-style: italic;
				opacity: 75%;
			}
		}

	}

</style>