<script>
    import { onDestroy, onMount } from 'svelte'

	import { Flex, Inline, Popover, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'
	import Label  from '@/Components/UI/Inputs/Label.svelte'

    let {
        class: className,
		icon,
		iconSize,
		inputClass,
		label,
		labelIcon,
		size = "md",
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

</script>



<Flex align="center" justify="start" class="input p-{size} text-{size} {className} {restProps.disabled ? 'disabled' : ''} {hasFocus ? 'focus' : ''}">
	
	{#if icon}
		<Icon name={icon} size={size} weight="regular" />
	{/if}

	<input
		aria-disabled={restProps.disabled ? 'true' : undefined}
		bind:value
		bind:this={input}
		class="input-element p-0 {inputClass}"
		onfocus={checkFocus}
		onblur={checkFocus}
		{...restProps}
	/>

</Flex>