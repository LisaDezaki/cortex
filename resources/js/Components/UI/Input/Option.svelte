<script>

	import Flex      from '@/Components/Core/Flex.svelte'
	import Badge     from '@/Components/UI/Badge.svelte'
	import Icon      from '@/Components/UI/Icon.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'
    import clsx from 'clsx'

	let {
		active = false,
        class: className,
		checked = false,
		count,
		hideCount = false,
		icon,
		image,
		isOpen = $bindable(false),
		item,
		label,
		onclick,
		options,
		placeholder,
		size = 'md',
		theme = 'neutral',
		value
    } = $props()

	let cx = {
		option: clsx('input-option flex items-center w-full', theme, {
			'active': active || checked,
			// 'hover:bg-neutral-softest text-neutral': theme === 'neutral',
			// 'hover:bg-danger-softest text-danger': theme === 'danger',
		}, className),
		icon:	clsx('input-icon'),
		text:	clsx('break-all line-clamp-1 px-1.5 text-left w-full', `text-${size}`),
		// value:	clsx('text-neutral'),
		placeholder: clsx('text-neutral-softer italic')
	}

</script>



<Flex
	class={cx.option}
	onclick={onclick}
>
	{#if icon || item?.icon}
		<Icon class={cx.icon}
			name={icon || item?.icon}
			size={size}
		/>
	{:else if image || item?.image}
		<Thumbnail
			class="rounded-full p-[1px] w-6"
			iconSize={16}
			imageClass="rounded-full"
			src={image || item?.image}
		/>
	{/if}

	{#if label && label || item?.label}
		<span class="{cx.text} {cx.value}">{label || item?.label}</span>
	{:else if placeholder || item?.placeholder}
		<span class="{cx.text} {cx.placeholder}">{placeholder || item?.placeholder}</span>
	{/if}

	{#if (count || item?.count) && !hideCount}
		<Badge style="soft" theme="accent" text={count || item?.count} />
	{/if}

	{#if options || item?.options}
		<Icon
			name="CaretRight"
			size="sm"
			class="text-neutral-softest ml-auto"
		/>
	{/if}

	{#if checked || item?.checked}
		<Icon
			name="Check"
			size="sm"
			class="ml-auto"
		/>
	{/if}

</Flex>