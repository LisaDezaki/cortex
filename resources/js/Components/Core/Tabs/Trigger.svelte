<script>
	import { Tabs } from "bits-ui"
	let {
		active,
		children,
		class: className,
		...restProps
	} = $props()
</script>

<Tabs.Trigger class="tab-trigger {className}" {...restProps}>
	{@render children()}
</Tabs.Trigger>