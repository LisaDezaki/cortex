<script>
	import { Tabs } from "bits-ui"
	let {
		active,
		children,
		class: className,
		...attrs
	} = $props()
</script>

<Tabs.Trigger class="tab-trigger font-style-button {className}" {...attrs}>
	{@render children()}
</Tabs.Trigger>

<style lang="postcss">

	:global(.tab-trigger) {
		@apply inline-flex items-center justify-center px-3 py-2 rounded w-full;
		@apply transition duration-150 ease-in-out bg-transparent border border-transparent;
		@apply focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2;
		&[aria-selected="true"] {
			background: var(--gradient-primary);
			border-color: var(--border-primary);
			color: var(--text-white);
		}
		&:hover {
			background-color: var(--bg-disabled);
		}
	}

</style>