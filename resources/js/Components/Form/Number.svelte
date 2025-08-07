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
	let step     = $state( Number(restProps.step) || 1 )

	function checkFocus() {
		hasFocus = document.activeElement === input;
	}

    export function focus() {
        input?.focus()
    }

    onMount(() => {
        if (restProps.autofocus && input) {
            input.focus()
        }
    })

	function decrement() {
		if (restProps.min && Number(restProps.min) > Number(value) - step) { return }
		value = Number(value) - step
	}

	function increment() {
		if (restProps.max && Number(restProps.max) < Number(value) + step) { return }
		value = Number(value) + step
	}

</script>





<div class="input-number {className}" class:disabled={restProps.disabled} class:focus={hasFocus}>

	{#if icon}
		<Icon class="input-icon" name={icon} size={20} weight="regular" />
	{/if}

	<input type="number"
		aria-disabled={restProps.disabled ? 'true' : undefined}
		class="input-element {icon ? "pl-icon" : ""}"
		bind:value
		bind:this={input}
		onfocus={checkFocus}
		onblur={checkFocus}
		{...restProps}
	/>

	<div class="flex items-center">
		<Button style="plain" theme={value - step < restProps.min ? "neutral" : "accent"}
			class="input-action"
			disabled={value - step < restProps.min || restProps.disabled}
			icon="Minus" iconSize={16}
			onclick={decrement}
		/>
		<Button style="plain" theme={value + step > restProps.max ? "neutral" : "accent"}
			class="input-action"
			disabled={value + step > restProps.max || restProps.disabled}
			icon="Plus" iconSize={16}
			onclick={increment}
		/>
	</div>

</div>