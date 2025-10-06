<script>
	import { onMount, onDestroy } from 'svelte';

	import { Inline } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Icon from '@/Components/UI/Icon.svelte'
	
	let {
		error,
		errors,
		icon,
		message,
		success,
		onDismiss
	} = $props()

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
	<Inline class="toast backdrop-blur bg-accent-gradient border border-accent-strong fixed bottom-8 left-1/2 p-1.5 pl-3 rounded-full shadow-xl text-white translate-x-[-50%] z-50">
		<Icon name={icon || 'Check'} size="md" weight="bold" />
		<span class="font-medium">{success}</span>
		<Button onclick={dismiss} icon="X" iconSize="sm" iconWeight="bold" style="plain" theme="danger" class="bg-accent-gradient-flip ml-3 rounded-full" />
	</Inline>
{/if}

{#if visible && message}
	<Inline class="toast bg-neutral-softer backdrop-blur-sm border border-neutral-soft fixed bottom-8 left-1/2 p-1.5 pl-3 rounded-full shadow-xl text-neutral translate-x-[-50%] z-50">
		<Icon name={icon || 'Info'} size="md" weight="fill" />
		<span class="font-medium">{message}</span>
		<Button onclick={dismiss} icon="X" iconSize="sm" iconWeight="light" style="plain" theme="danger" class="ml-3 rounded-full" />
	</Inline>
{/if}

{#if visible && error}
	<Inline class="toast bg-danger-gradient border border-danger-strong fixed bottom-8 left-1/2 p-1.5 pl-3 rounded-full shadow-xl text-white translate-x-[-50%] z-50">
		<Icon name={icon || 'SmileySad'} size="md" weight="fill" />
		<span class="font-medium">{error}</span>
		<Button onclick={dismiss} icon="X" iconSize="sm" iconWeight="light" style="plain" theme="danger" class="ml-3 rounded-full" />
	</Inline>
{/if}

{#if visible && errors}
	{#each errors as error}
		<Inline class="toast bg-danger-gradient border border-danger-strong fixed bottom-8 left-1/2 p-1.5 pl-3 rounded-full shadow-xl text-white translate-x-[-50%] z-50">
			<Icon name={icon || 'SmileySad'} size="md" weight="fill" />
			<span class="font-medium">{error}</span>
			<Button onclick={dismiss} icon="X" iconSize="sm" iconWeight="light" style="plain" theme="danger" class="ml-3 rounded-full" />
		</Inline>
	{/each}
{/if}