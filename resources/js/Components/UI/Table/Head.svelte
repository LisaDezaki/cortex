<script>
	import Icon from '@/Components/UI/Icon.svelte'
	import clsx from "clsx"

    let {
		checkbox,
		children,
        class: className,
		shrink = false,
		sortable = false,
        ...restProps
    } = $props()

	let cx = {
		cell: clsx('inline-flex font-medium gap-1 py-1 text-left text-neutral', {
			'shrink': shrink
		}, className)
	}
</script>

<th class={cx.cell} {...restProps}>
	{@render children()}
	{#if sortable}
		<Icon name="SortAscending" size={16} />
	{/if}
</th>

<style lang="postcss">

	th {
		border-bottom: 2px solid var(--border-neutral-softest);
	}
	th.shrink {
		@apply min-w-12 basis-0;
	}
	th:not(.shrink) {
		@apply flex-grow basis-1;
	}

</style>