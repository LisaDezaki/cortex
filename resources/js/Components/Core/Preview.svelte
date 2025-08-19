<script>
	import { LinkPreview } from "bits-ui";

	let {
		children,
		class: className,
		content,
		contentClass,
		trigger,
		triggerClass,
		...restProps
	} = $props()
</script>

<LinkPreview.Root class={className} openDelay={100} {...restProps}>
	<LinkPreview.Trigger class={triggerClass}>
		{@render children?.()}
		{@render trigger?.()}
	</LinkPreview.Trigger>
	<LinkPreview.Content sideOffset={4} class={contentClass}>
		{@render content?.()}
	</LinkPreview.Content>
</LinkPreview.Root>