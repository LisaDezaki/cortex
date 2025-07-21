<!-- SCRIPT -->

<script>
	
	import { DropdownMenu } from "bits-ui";

	let {
		children,
        class: className,
		content,
		label,
        ...attrs
    } = $props()

</script>



<!-- STRUCTURE -->
 
<DropdownMenu.Root class="dropdown" {...attrs}>

	<DropdownMenu.Trigger class="dropdown-trigger {className}">
		{@render children()}
	</DropdownMenu.Trigger>
 
	<DropdownMenu.Portal>
		<DropdownMenu.Content class="dropdown-content" alignOffset={0} sideOffset={0}>
			{@render content()}
		</DropdownMenu.Content>
	</DropdownMenu.Portal>
</DropdownMenu.Root>



<!-- STYLE -->
 
<style lang="postcss">

	:global(.dropdown-content) {
		@apply block max-h-72 p-1 w-56 ;
		@apply border rounded-lg shadow-2xl z-10;
		background-color: var(--bg-white);
		border-color: var(--border-input);
		color: var(--text-input);
	}

</style>