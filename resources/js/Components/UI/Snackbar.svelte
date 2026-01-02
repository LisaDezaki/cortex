<script>
	import { onMount, onDestroy } from 'svelte';
	import { Link, page } from '@inertiajs/svelte'

	import { Flex, Inline, Stack } from '@/Components/Core'
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
		duration = 5000,
		onDismiss,
		theme
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		snackbar: clsx({
			'snackbar border-b max-h-48 min-w-48 rounded shadow-xl text-white z-50': true,
			'bg-accent-gradient	border-accent-strong	text-white':	theme === 'accent',
			'bg-slate-50		border-neutral-softer	text-neutral':	theme === 'neutral',
			'bg-danger-gradient	border-danger-strong	text-white':	theme === 'danger'
		}, className),
		text:	clsx('max-h-48 overflow-y-auto px-1'),
		button: clsx({
			'ml-3 rounded-full': true,
			'bg-accent-gradient-flip': success
		})
	})

	let progress = $state(0)
	let startTime = $state(0)
	let rafId

	let visible = $state(false)
	let timeoutId

	function dismiss() {
		visible = false
	}

	function animateProgress(timestamp) {
		if (!startTime) startTime = timestamp
		const elapsed = timestamp - startTime
		progress = Math.min((elapsed/duration) * 100, 100)
		if (progress < 100) rafId = requestAnimationFrame(animateProgress)
	}

	onMount(() => {
		startTime = 0
		progress = 0
		rafId = requestAnimationFrame(animateProgress)
		visible = true
		timeoutId = setTimeout(dismiss, duration)
	});

	onDestroy(() => {
		clearTimeout(timeoutId);
	})

</script>


{#if visible}
	<Stack class={cx.snackbar} gap={1}>
		<Flex align="center" gap={1} class="px-2 pt-1">
			<Icon name={icon} size="md" />
			<span class={cx.text}>{text}</span>
			{#if action}
				<Button class="bg-white/10 font-style-button ml-1.5" onclick={action.onclick}>{action.label}</Button>
			{/if}
			{#if dismissable}
				<Button class="ml-1.5" icon="X" size="sm" onclick={dismiss} />
			{/if}
		</Flex>
		<Flex class="bg-black/20 h-[1px] overflow-hidden rounded-full w-full">
			<Inline class="bg-white rounded-full" style="width: {progress}%"></Inline>
		</Flex>
	</Stack>
{/if}