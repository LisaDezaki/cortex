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





<Tabs class="article-tabs {className}" orientation="vertical" {...restProps}>

	<Tabs.List class="pt-12 w-56">
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

	:global(.article-tabs) {
		@apply flex items-start gap-12 w-full;

		:global(.tab-trigger) {
			@apply flex items-center justify-start gap-2 px-3 py-1.5 rounded w-full;
			&[aria-selected="true"] {
				color: var(--text-accent);
			}
			&:hover {
				background-color: var(--bg-neutral-softest);
			}
		}
	}

</style>