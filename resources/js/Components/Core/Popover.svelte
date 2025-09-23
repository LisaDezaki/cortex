<script>
	import { Popover } from "bits-ui";

	let {
		children,
		class: className,
		content,
		contentProps,
		...restProps
	} = $props()

</script>
 
<Popover.Root class={className} {...restProps}>
  	<Popover.Trigger>
		{@render children?.()}
	</Popover.Trigger>
	<Popover.Content {...contentProps}>
		{@render content?.()}
		<!-- <Popover.Close />
		<Popover.Arrow /> -->
	</Popover.Content>
</Popover.Root>