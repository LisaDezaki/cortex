<script>
	import { Tabs } from "bits-ui"
	let {
		children,
		class: className,
		...restProps
	} = $props()
</script>

<Tabs.List class="tabs-list {className}" {...restProps}>
	{@render children()}
</Tabs.List>