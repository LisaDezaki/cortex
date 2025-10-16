<script>
    import { onMount } from 'svelte'

    let {
        class: className,
		inputClass,
        value = $bindable(),
        ...restProps
    } = $props()

	let input
	let hasFocus = $state(false)

	function checkFocus() {
		hasFocus = document.activeElement === input;
	}

    onMount(() => {
        if (restProps.autofocus && input) {
			hasFocus = true
            input.focus()
        }
    })

    export function focus() {
        input?.focus()
    }

    onMount(() => {
        if (restProps.autofocus && input) {
            input.focus()
        }
    })

</script>





<textarea
	bind:this={input}
	aria-disabled={restProps.disabled ? true : undefined}
	class="input-textarea {className} {inputClass}"
	class:focus={hasFocus}
	onfocus={checkFocus}
	onblur={checkFocus}
	bind:value
	{...restProps}
></textarea>

<style lang="postcss">

	.input-textarea {
		@apply px-3 py-2;
	}

</style>