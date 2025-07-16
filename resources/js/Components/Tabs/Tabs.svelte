<script>
	import { Tabs } from "bits-ui"
	let {
		children,
		class: className,
		...attrs
	} = $props()
</script>

<Tabs.Root class="tabs {className}" {...attrs}>
	{@render children()}
</Tabs.Root>

<style lang="postcss">

	:global(.tabs) {
		@apply w-full;
	}

</style>