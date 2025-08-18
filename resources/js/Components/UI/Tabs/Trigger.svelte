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

<style lang="postcss">

	:global(.tab-trigger[data-orientation="horizontal"]) {
		@apply inline-flex items-center justify-center px-3 py-2 rounded w-full;
		@apply transition duration-150 ease-in-out bg-transparent border border-transparent;
		@apply focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2;
		&[aria-selected="true"] {
			background: var(--bg-accent-gradient);
			border-color: var(--border-accent-strong);
			color: var(--text-white);
		}
		&:hover {
			background-color: var(--bg-neutral-softer);
		}
	}

	:global(.tab-trigger[data-orientation="vertical"]) {
		@apply flex items-center justify-start gap-2 px-3 py-1.5 rounded w-full;
		&[aria-selected="true"] {
			color: var(--text-accent);
		}
		&:hover {
			background-color: var(--bg-neutral-softest);
		}
	}

</style>