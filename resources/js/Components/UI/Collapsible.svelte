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


{#if children}
	<div class={className}>
		
		<p class="whitespace-pre-wrap {collapsed ? collapsedClass : ''}">{@render children?.()}</p>
		
		<button class="self-center -mx-2 mt-2 px-2 py-1 text-accent text-sm hover:underline"
			onclick={() => collapsed = !collapsed}>
			{#if collapsed}
				Read more&hellip;
			{:else}
				Read less&hellip;
			{/if}
		</button>

	</div>
{/if}