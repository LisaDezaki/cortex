<script>

    let {
		children,
        class: className,
		shrink = false,
        ...restProps
    } = $props()
</script>

<td class="{className} {shrink ? 'shrink' : ''}" {...restProps}>
	<div class="cell">
		{@render children()}
	</div>
</td>

<style lang="postcss">

	td {
		@apply inline-flex items-center overflow-hidden;
	}
	td.shrink {
		@apply min-w-12 basis-0;
	}
	td:not(.shrink) {
		@apply flex-grow basis-1;
	}

	td .cell {
		@apply inline-flex items-center gap-3 p-1 w-full;
	}

</style>