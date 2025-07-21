<script>
	import Icon from '@/Components/Icon.svelte'
	import Tag from '@/Components/Tag.svelte'
	import Tooltip from '@/Components/Tooltip.svelte'

    let {
        class: className,
        children,
		description,
		for: labelFor,
		info,
		inline,
		required,
        value,
        ...attrs
    } = $props()
</script>

<label
	for={labelFor}
	{...attrs}
	class="label {className}"
	class:disabled={attrs.disabled}
	class:inline={inline}
>
    {#if value}
        {value}
    {:else if children}
        {@render children()}
    {/if}

	<!-- {#if required}
		<Tag secondary>Required</Tag>
	{/if} -->

	{#if description}
		<Tooltip class="ml-auto text-slate-400/40 hover:text-emerald-500">
			<Icon class="label-description" name="Info" size={16} weight="fill" />
			{#snippet content()}
				{description}
			{/snippet}
		</Tooltip>
	{/if}

</label>

<style lang="postcss">

	label {
		@apply flex items-center gap-2;
		&:not(.inline) {
			@apply text-sm;
			&:not([class*="text-"]) {
				color: var(--text-label);
			}
		}
	}

	label.inline {
		@apply inline-flex items-center my-1 flex-shrink w-full;
		&:not(.disabled):not([class*="text-"]) {
			color: var(--text-body);
		}
		&.disabled:not([class*="text-"]) {
			color: var(--text-disabled);
		}
	}

</style>