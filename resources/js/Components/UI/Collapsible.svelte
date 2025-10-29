<script>
	import Stack from '@/Components/Core/Stack.svelte'
	import Button from '@/Components/UI/Button.svelte'

	let {
		children,
		class: className,
		collapsed = $bindable(true),
		collapsedClass = 'line-clamp-3 overflow-hidden',
		...restProps
	} = $props()
</script>


{#if children}
	<Stack class={className}>
		
		<p class="whitespace-pre-wrap {collapsed ? collapsedClass : ''}">{@render children?.()}</p>
		
		<Button size="xs" style="plain" theme="accent"
			class="bg-accent-softest self-center mx-auto mt-2 px-2 py-1 rounded-full text-accent text-xs hover:underline"
			onclick={() => collapsed = !collapsed}>
			{#if collapsed}
				Read more&hellip;
			{:else}
				Read less&hellip;
			{/if}
		</Button>

	</Stack>
{/if}