<script>
	import { onMount, onDestroy } from 'svelte';
	import { Link, page } from '@inertiajs/svelte'

	import { Inline } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Icon from '@/Components/UI/Icon.svelte'
    import clsx from 'clsx'
	
	let {
		action,
		class: className,
		error,
		errors,
		icon = 'Check',
		text,
		success,
		dismissable = true,
		onDismiss,
		theme
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		snackbar: clsx({
			'snackbar border-b px-2 py-1.5 rounded shadow-xl text-white z-50': true,
			'bg-accent-gradient	border-accent-strong	text-white':	theme === 'accent',
			'bg-slate-50		border-neutral-softer	text-neutral':	theme === 'neutral',
			'bg-danger-gradient	border-danger-strong	text-white':	theme === 'danger'
		}, className),
		text:	clsx('px-1'),
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



<Inline class={cx.snackbar} align="center" gap={1}>
	<Icon name={icon} size="md" />
	<span class={cx.text}>{text}</span>
	{#if action}
		<Button class="bg-white/10 font-style-button ml-1.5" onclick={action.onclick}>{action.label}</Button>
	{/if}
	{#if dismissable}
		<Button class="ml-1.5" icon="X" size="sm" onclick={dismiss} />
	{/if}
</Inline>