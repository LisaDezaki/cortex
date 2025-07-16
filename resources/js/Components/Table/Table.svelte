<script>

	import Row from './Row.svelte';

    let {
		children,
        class: className,
		data,
		headRow,
		bodyRow,
        ...attrs
    } = $props()

</script>

<table class={className} {...attrs}>
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
			box-shadow: inset 0  1px  0 var(--shadow-highlight),
						inset 0 -1px  0 var(--shadow-lowlight);
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
			background-color: rgba(0,0,0,0.05);
			box-shadow: none;
		}
	}

</style>