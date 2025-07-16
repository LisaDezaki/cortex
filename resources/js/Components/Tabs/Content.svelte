<script>
	import { Tabs } from "bits-ui"
	let {
		active,
		children,
		class: className,
		...attrs
	} = $props()
</script>

<Tabs.Content class="tabs-content {className}" {...attrs}>
	{#if children}
		{@render children()}
	{/if}
</Tabs.Content>