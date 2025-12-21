<script>
	import Inline from '@/Components/Core/Inline.svelte'
	import Icon    from '@/Components/UI/Icon.svelte'
	import Tag     from '@/Components/UI/Tag.svelte'
	import Tooltip from '@/Components/UI/Tooltip.svelte'

    let {
        class: className,
        children,
		description,
		for: labelFor,
		icon,
		info,
		inline,
		required,
		text,
        value,
        ...restProps
    } = $props()
</script>

<label
	for={labelFor}
	{...restProps}
	class="label font-style-label {className}"
	class:disabled={restProps.disabled}
	class:inline={inline}
>
    {#if text}
		<Inline align="center" gap={1} class="my-0.5">
			{#if icon}
				<Icon name={icon} size="xs" weight="regular" />
			{/if}
			<span class="font-light">{text}</span>
		</Inline>
    {:else if children}
        {@render children()}
    {/if}

	<!-- {#if required}
		<Tag secondary>Required</Tag>
	{/if} -->

	{#if description}
		<Tooltip class="ml-auto hover:text-emerald-500">
			<Icon class="label-description" name="Info" size={16} weight="fill" />
			{#snippet content()}
				{description}
			{/snippet}
		</Tooltip>
	{/if}

</label>

<style lang="postcss">

	label {
		/* @apply flex gap-2; */
		&:not(.inline) {
			/* @apply text-xs; */
			&:not([class*="text-"]) {
				color: var(--text-neutral-soft);
			}
		}
	}

	label.inline {
		@apply inline-flex items-center my-1 flex-shrink w-full;
		&:not(.disabled):not([class*="text-"]) {
			color: var(--text-neutral);
		}
		&.disabled:not([class*="text-"]) {
			color: var(--text-disabled);
		}
	}

</style>