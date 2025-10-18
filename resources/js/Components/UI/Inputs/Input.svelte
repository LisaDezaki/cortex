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



<Stack gap={0.5}>

	{#if label}
		<Flex align="center" justify="start" gap={1} class="font-light text-neutral-soft w-full">
			{#if labelIcon}
				<Icon name={labelIcon} size="xs" />
			{/if}
			<Label
				class="font-style-label"
				value={label}
			/>
		</Flex>
	{/if}

	<Flex align="center" justify="start" class="input p-1 {className} {restProps.disabled ? 'disabled' : ''} {hasFocus ? 'focus' : ''}">
		{#if icon}
			<Icon name={icon} size={iconSize} weight="regular" />
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

</Stack>