<script>
    import { onDestroy, onMount } from 'svelte'

	import Flex from '@/Components/Core/Flex.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'
    import clsx from 'clsx'

    let {
        class: className,
		icon,
		iconSize,
		inputClass,
		label,
		labelIcon,
		size = "md",
		type = "text",
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
			input.click()
        }
    })

	onDestroy(() => {
		hasFocus = false
	})

	let cx = $derived({
		input: clsx('input', `p-${size}`, {
			'disabled': restProps.disabled,
			'focus': hasFocus
		}, className),
		element: clsx('input-element', `px-${size} py-0 text-${size}`, inputClass)
	})

</script>



<Flex align="center" justify="start" class={cx.input}>

	{#if icon}
		<Icon class="input-icon" name={icon} size={size} weight="regular" />
	{/if}

	<input
		bind:this={input}
		bind:value
		type={type}
		aria-disabled={restProps.disabled ? 'true' : undefined}
		class={cx.element}
		onfocus={checkFocus}
		onblur={checkFocus}
		{...restProps}
	/>

</Flex>