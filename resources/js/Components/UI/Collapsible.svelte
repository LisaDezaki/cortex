<script>
	import Button from '@/Components/UI/Button.svelte'

	let {
		children,
		class: className,
		collapsed = $bindable(true),
		collapsedClass = 'line-clamp-3 overflow-hidden',
		...restProps
	} = $props()
</script>



<div class={className}>
	
	<p class="whitespace-pre-wrap {collapsed ? collapsedClass : ''}">{@render children?.()}</p>
	
	<Button style="plain" theme="accent" class="self-center mt-3 text-sm"
		onclick={() => collapsed = !collapsed}>
		{#if collapsed}
			Read more&hellip;
		{:else}
			Read less&hellip;
		{/if}
	</Button>

</div>
