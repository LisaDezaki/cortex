<script>
    import { onMount } from 'svelte'

	import Button from '@/Components/Button.svelte'
	import Icon from '@/Components/Icon.svelte'

    let {
        class: className,
		icon,
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

</script>




<div
	class="input {className}"
	class:disabled={restProps.disabled}
	class:focus={hasFocus}
>
	{#if icon}
		<Icon class="input-icon" name={icon} size={20} weight="regular" />
	{/if}

	<input
		aria-disabled={restProps.disabled ? 'true' : undefined}
		bind:value
		bind:this={input}
		class="input-element {icon ? "pl-icon" : ""}"
		onfocus={checkFocus}
		onblur={checkFocus}
		{...restProps}
	/>
</div>