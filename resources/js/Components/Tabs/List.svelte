<script>
	import { Tabs } from "bits-ui"
	let {
		children,
		class: className,
		...attrs
	} = $props()
</script>

<Tabs.List class="tabs-list {className}" {...attrs}>
	{@render children()}
</Tabs.List>

<style lang="postcss">

	:global(.tabs-list) {
		@apply flex gap-0.5 p-0.5 rounded-lg mb-4 border;
		background-color: var(--bg-neutral-soft);
		border-color: var(--border-neutral-soft);
	}

</style>