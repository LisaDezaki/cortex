<script>

	import Flex      from '@/Components/Core/Flex.svelte'
	import Icon      from '@/Components/UI/Icon.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	let {
		active = false,
        class: className,
		checked = false,
		icon,
		image,
		isOpen = $bindable(false),
		item,
		label,
		onclick,
		options,
		placeholder,
		value = $bindable()
    } = $props()

</script>


<Flex align="center" gap={0.5} onclick={onclick}
	class="input-option text-sm w-full {className} {active || checked ? 'active' : ''}"
>
	{#if icon || item?.icon}
		<Icon name={icon || item?.icon} size="md" />
	{:else if image || item?.image}
		<Thumbnail
			class="rounded-full p-[1px] w-6"
			iconSize={16}
			imageClass="rounded-full"
			src={image || item?.image}
		/>
	{/if}

	{#if label || item?.label}
		<span class="line-clamp-1 px-1 text-left w-full font-style-value">{label || item?.label}</span>
	{:else if placeholder || item?.placeholder}
		<span class="line-clamp-1 px-1 text-left w-full font-style-placeholder">{placeholder || item?.placeholder}</span>
	{/if}

	{#if options || item?.options}
		<Icon name="CaretRight" size="sm" class="text-neutral-softest ml-auto" />
	{/if}

	{#if checked || item?.checked}
		<Icon name="Check" size="sm" class="ml-auto" />
	{/if}

</Flex>