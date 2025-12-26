<script>
    import { onDestroy, onMount } from 'svelte'

	import Flex from '@/Components/Core/Flex.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'
	import clsx from 'clsx'

    let {
        class: className,
		icon,
		inputClass,
		size = "md",
        value = $bindable(),
        ...restProps
    } = $props()

    let input
	let hasFocus = $state(false)
	let step     = $state( Number(restProps.step) || 1 )

	function checkFocus() {
		hasFocus = document.activeElement === input;
	}

    export function focus() {
        input?.focus()
    }

    onMount(() => {
        if (restProps.autofocus && input) {
			hasFocus = true
            input.focus()
			input.click()
        }
    })

	onDestroy(() => {
		hasFocus = false
	})

	function decrement() {
		if (restProps.min && Number(restProps.min) > Number(value) - step) { return }
		value = Number(value) - step
	}

	function increment() {
		if (restProps.max && Number(restProps.max) < Number(value) + step) { return }
		value = Number(value) + step
	}

	let cx = $derived({
		input: clsx('input', `p-${size}`, `text-${size}`, {
			'disabled': restProps.disabled,
			'focus': hasFocus
		}, className),
		element: clsx('input-element', `px-${size} py-0 text-${size}`)
	})

</script>





<Flex align="center" justify="start" class={cx.input}>

	{#if icon}
		<Icon class="input-icon" name={icon} size={size} weight="regular" />
	{/if}

	<input
		bind:this={input}
		bind:value
		type="number"
		aria-disabled={restProps.disabled ? 'true' : undefined}
		class={cx.element}
		onfocus={checkFocus}
		onblur={checkFocus}
		{...restProps}
	/>

</Flex>