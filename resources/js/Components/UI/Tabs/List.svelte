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

<style lang="postcss">

	:global(.tabs-list[data-orientation="horizontal"]) {
		@apply flex gap-0.5 p-0.5 rounded-lg mb-4 border;
		background-color: var(--bg-neutral-softest);
		border-color: var(--border-neutral-softest);
		&[data-orientation="vertical"] {
			@apply flex-col;
		}
	}

</style>