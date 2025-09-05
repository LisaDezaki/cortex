<script>
	import { Inline } from '@/Components/Core'
	import Icon from '@/Components/UI/Icon.svelte'
	
	let {
		error,
		icon,
		message,
		success,
	} = $props()

</script>





{#if success}
	<Inline class="toast backdrop-blur bg-accent-softer border border-accent fixed bottom-8 left-1/2 px-3 py-1.5 rounded-full shadow-xl text-accent translate-x-[-50%] z-50">
		<Icon name={icon || 'Check'} size="md" weight="bold" />
		<span class="font-medium">{success}</span>
	</Inline>
{/if}

{#if message}
	<Inline class="toast bg-neutral-softer backdrop-blur-sm border border-neutral-soft fixed bottom-8 left-1/2 px-3 py-1.5 rounded-full shadow-xl text-neutral translate-x-[-50%] z-50">
		<Icon name={icon || 'Info'} size="md" weight="fill" />
		<span class="font-medium">{message}</span>
	</Inline>
{/if}

{#if error}
	<Inline class="toast bg-danger-gradient border border-danger-strong fixed bottom-8 left-1/2 px-3 py-1.5 rounded-full shadow-xl text-white translate-x-[-50%] z-50">
		<Icon name={icon || 'SmileySad'} size="md" weight="fill" />
		<span class="font-medium">{error}</span>
	</Inline>
{/if}