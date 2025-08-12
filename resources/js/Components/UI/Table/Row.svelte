<script>

    let {
		children,
        class: className,
        ...restProps
    } = $props()

</script>

<tr class={className} {...restProps}>
	{@render children()}
</tr>