<script>

	import Box from '@/Components/Core/Box.svelte';
	import Row from './Row.svelte';

    let {
		children,
        class: className,
		data,
		headRow,
		bodyRow,
        ...restProps
    } = $props()

</script>

<Box class={className}>
	<table {...restProps}>
		{#if headRow}
			<thead>
				<Row>
					{@render headRow()}
				</Row>
			</thead>
		{/if}
		<tbody>
			{#each data as item}
				<Row>
					{@render bodyRow(item)}
				</Row>
			{/each}
		</tbody>
	</table>
</Box>

<style lang="postcss">

	table {
		@apply w-full;

		:global(thead tr) {
			display: flex;
			@apply w-full;
		}

		:global(tbody tr) {
			display: flex;
			@apply w-full;
			/* box-shadow: inset 0  1px  0 var(--shadow-highlight),
						inset 0 -1px  0 var(--shadow-lowlight); */
		}

		:global(tbody tr:not(:last-of-type)) {
			@apply border-b;
			border-color: var(--border-neutral-softest);
		}

		:global(tr th:first-of-type),
		:global(tr td:first-of-type) {
			@apply pl-3;
		}

		:global(tr th:last-of-type),
		:global(tr td:last-of-type) {
			@apply pr-3;
		}
		
		:global(tbody tr:hover) {
			background-color: var(--bg-neutral-softest);
			/* box-shadow: none; */
		}
	}

</style>