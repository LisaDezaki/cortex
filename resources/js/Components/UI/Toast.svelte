<script>
	import { onMount, onDestroy } from 'svelte';

	import { Inline } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Icon from '@/Components/UI/Icon.svelte'
    import clsx from 'clsx'
	
	let {
		class: className,
		error,
		errors,
		icon,
		message,
		success,
		onDismiss
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		toast: clsx({
			'toast fixed bottom-8 left-1/2 font-medium p-1.5 pl-3 rounded-full shadow-xl text-white translate-x-[-50%] z-50': true,
			'backdrop-blur bg-accent-gradient border border-accent-strong text-white': success,
			'bg-neutral-softer backdrop-blur-sm border border-neutral-soft text-neutral': message,
			'bg-danger-gradient border border-danger-strong text-white': error || errors,
		}, className),
		button: clsx({
			'ml-3 rounded-full': true,
			'bg-accent-gradient-flip': success
		})
	})

	let visible = $state(false)
	let timeoutId

	function dismiss() {
		visible = false
	}

	onMount(() => {
		visible = true
		timeoutId = setTimeout(dismiss,5000)
	});

	onDestroy(() => {
		clearTimeout(timeoutId);
	})

</script>





{#if visible && success}
	<Inline class={cx.toast}>
		<Icon name={icon || 'Check'} size="md" weight="bold" />
		<span>{success}</span>
		<Button style="plain" theme="danger" icon="X" iconSize="sm" iconWeight="bold" onclick={dismiss} />
	</Inline>
{/if}

{#if visible && message}
	<Inline class={cx.toast}>
		<Icon name={icon || 'Info'} size="md" weight="fill" />
		<span>{message}</span>
		<Button style="plain" theme="danger" icon="X" iconSize="sm" iconWeight="light" onclick={dismiss} />
	</Inline>
{/if}

{#if visible && error}
	<Inline class={cx.toast}>
		<Icon name={icon || 'SmileySad'} size="md" weight="fill" />
		<span>{error}</span>
		<Button style="plain" theme="danger" icon="X" iconSize="sm" iconWeight="light" onclick={dismiss} />
	</Inline>
{/if}

{#if visible && errors}
	{#each errors as error}
		<Inline class={cx.toast}>
			<Icon name={icon || 'SmileySad'} size="md" weight="fill" />
			<span>{error}</span>
			<Button style="plain" theme="danger" icon="X" iconSize="sm" iconWeight="light" onclick={dismiss} />
		</Inline>
	{/each}
{/if}