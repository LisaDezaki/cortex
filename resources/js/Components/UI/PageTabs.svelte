<script>

	import { Tabs } from '@/Components/Core'
	import Icon from '@/Components/UI/Icon.svelte'

	let {
		children,
		class: className,
		tabs,
		...restProps
	} = $props()

</script>





<Tabs class="page-tabs {className}" {...restProps}>

	<Tabs.List>
		{#each tabs as tab}
			<Tabs.Trigger value={tab.value}>
				{#if tab.icon}
					<Icon name={tab.icon} size="md" />
				{/if}
				<span class:text-accent={tab.active}>{tab.label}</span>
			</Tabs.Trigger>
		{/each}
	</Tabs.List>

	{@render children?.()}

</Tabs>


<style lang="postcss">

	:global(.page-tabs) {
		@apply w-full;

		:global(.tabs-list) {
			@apply flex gap-0.5 p-0.5 rounded-lg mb-4 border;
			background-color: var(--bg-neutral-softest);
			border-color: var(--border-neutral-softest);
			&[data-orientation="vertical"] {
				@apply flex-col;
			}

			:global(.tab-trigger) {
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
		}
	}

</style>