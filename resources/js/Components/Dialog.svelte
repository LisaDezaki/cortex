<script>
  	import { Dialog } from "bits-ui";

	let {
		open = $bindable(false),
		children,
		buttonText,
		title,
		description,
		contentProps,
		...restProps
  } = $props();

</script>
 
<Dialog.Root bind:open {...restProps}>
	<Dialog.Trigger>
		{@render children?.()}
	</Dialog.Trigger>
	<Dialog.Portal>
		<Dialog.Overlay />
		<Dialog.Content {...contentProps}>
			<Dialog.Title>
				{@render title()}
			</Dialog.Title>
			<Dialog.Description>
				{@render description()}
			</Dialog.Description>
			
			{@render content?.()}
			
			<Dialog.Close>Close Dialog</Dialog.Close>
		</Dialog.Content>
	</Dialog.Portal>
</Dialog.Root>