<script>
	import Icon from '@/Components/Icon.svelte'

    let {
		checkbox,
		children,
        class: className,
		shrink = false,
		sortable = false,
        ...restProps
    } = $props()
</script>

<th class="{className} {shrink ? 'shrink' : ''}" {...restProps}>
	<div class="cell font-label">
		{@render children()}
		{#if sortable}
			<Icon name="SortAscending" size={16} />
		{/if}
	</div>
</th>

<style lang="postcss">

	th {
		@apply inline-flex items-center font-medium;
		box-shadow: inset 0 -1px  0 var(--shadow-lowlight);
	}
	th.shrink {
		@apply min-w-12 basis-0;
	}
	th:not(.shrink) {
		@apply flex-grow basis-1;
	}

	th .cell {
		@apply inline-flex items-center gap-2 px-1.5 py-0.5 w-full;
	}

</style>