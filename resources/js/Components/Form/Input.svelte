<!-- SCRIPT -->

<script>
	
	//	Import onMount from Svelte to handle component lifecycle
    import { onMount } from 'svelte'

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

</script>



<!-- STRUCTURE -->

<input
    {...attrs}
	aria-disabled={attrs.disabled ? 'true' : undefined}
    class="style-input {className}"
    bind:value
    bind:this={input}
/>



<!-- STYLE -->

<style lang="postcss">

	input {
		@apply block min-h-10 rounded-lg w-full;
		@apply focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2;

		/* &::placeholder {
			color: var(--text-placeholder);
			font-style: italic;
			opacity: 75%;
		} */

		&[aria-disabled] {
			/* background-color: var(--bg-disabled);
			border-color: var(--border-disabled);
			color: var(--text-disabled); */
			opacity: 50%;
			cursor: not-allowed;
		}
	}

</style>