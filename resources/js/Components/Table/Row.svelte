<script>

    let {
		children,
        class: className,
        ...attrs
    } = $props()

</script>

<tr class={className} {...attrs}>
	{@render children()}
</tr>