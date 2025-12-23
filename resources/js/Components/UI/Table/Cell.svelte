<script>
    import clsx from "clsx"


    let {
		children,
        class: className,
		shrink = false,
        ...restProps
    } = $props()

	let cx = {
		cell: clsx('py-1', {
			'shrink': shrink
		}, className)
	}
</script>

<td class={cx.cell} {...restProps}>
	<!-- <div class="cell"> -->
	{@render children()}
	<!-- </div> -->
</td>

<style lang="postcss">

	td.shrink {
		@apply min-w-12 basis-0;
	}
	td:not(.shrink) {
		@apply flex-grow basis-1;
	}

	/* td .cell {
		@apply inline-flex flex-col items-start gap-3 py-1 w-full;
	} */

</style>