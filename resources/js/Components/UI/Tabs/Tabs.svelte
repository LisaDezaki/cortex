<script>
	import { Tabs } from "bits-ui"
	let {
		children,
		class: className,
		...restProps
	} = $props()
</script>

<Tabs.Root class="tabs {className}" {...restProps}>
	{@render children()}
</Tabs.Root>

<style lang="postcss">

	:global(.tabs) {
		@apply w-full;
	}

</style>