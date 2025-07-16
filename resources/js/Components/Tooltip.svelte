<script>
	import { Tooltip } from "bits-ui";
    let {
		children,
		class: className,
		content,
		...attrs
    } = $props()
</script>

<Tooltip.Root>
	<Tooltip.Trigger class="tooltip-trigger {className}">
		{#if children}
			{@render children()}
		{/if}
	</Tooltip.Trigger>
	<Tooltip.Portal>
		<Tooltip.Content class="tooltip-content">
			{#if content}
				{@render content()}
			{/if}
			<Tooltip.Arrow />
		</Tooltip.Content>
	</Tooltip.Portal>
</Tooltip.Root>

<style lang="postcss">

	:global(.tooltip-trigger) {
		@apply flex items-center
	}

	:global(.tooltip-content) {
		@apply border rounded-lg shadow-md text-sm mx-8 px-3 py-2 max-w-[45ch] z-50;
		@apply bg-emerald-500 border-emerald-600 text-white;
	}

	:global(.tooltip-content span) {
		@apply text-emerald-600;
	}

</style>