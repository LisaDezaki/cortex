<script>
	import { Tabs } from "bits-ui"
	let {
		active,
		children,
		class: className,
		...restProps
	} = $props()
</script>

<Tabs.Content class="tabs-content {className}" {...restProps}>
	{#if children}
		{@render children()}
	{/if}
</Tabs.Content>