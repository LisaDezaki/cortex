<script>
	import { Link, page } from '@inertiajs/svelte'
    import clsx from 'clsx'
	
	import { Flex, Inline, Stack } from '@/Components/Core'
	import Button      from '@/Components/UI/Button.svelte'
	import Heading      from '@/Components/UI/Heading.svelte'
	import Icon      from '@/Components/UI/Icon.svelte'
	import Input     from '@/Components/UI/Input'
	import url from '@/stores/urlStore'

    let {
		back,
		children,
		class: className,
		items,
		searchable,
        ...restProps
    } = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		menu: clsx('page-menu',
			'relative sticky items-center gap-3 flex-none rounded-lg overflow-y-auto',
			'   bg-surface        flex-row    top-0     px-3    py-1.5    w-full z-10',
			'lg:bg-transparent lg:flex-col lg:top-12 lg:px-0 lg:py-0   lg:w-48',
			className),
		back: clsx('border border-neutral-softest gap-1.5 place-self-start rounded-full hover:border-accent hover:text-accent'),
		list: clsx('page-menu-list flex-row lg:flex-col gap-3 lg:gap-0.5'),
		item: clsx('page-menu-item flex items-center gap-3 min-h-9 p-md pl-3 rounded w-full'),
		itemDefault: clsx('hover:bg-neutral-softest'),
		itemDanger:  clsx('text-danger hover:bg-danger-softest'),
		itemActive:  clsx('bg-accent-softest text-accent pointer-events-none')
	})

	/**
	 * Filter menu items
	 * @type {string}
	 */
	let query = $state('')

</script>



<Flex class={cx.menu} {...restProps}>

	{#if back}
		<Button class={cx.back} icon="ArrowElbowUpLeft" {...back} />
	{/if}

	{#if searchable}
		<div class="flex-shrink-0 px-1.5">
			<Input.Text type="search"
				class="page-menu-search"
				icon="MagnifyingGlass"
				placeholder="Search"
				oninput={filterItems}
				bind:value={query}
			/>
		</div>
	{/if}

	<Flex as="ul" class={cx.list}>
		{#if children}
			{@render children()}
		{/if}
		{#each items as item}
			{#if item.group}
				<span class="font-style-button mt-6 px-3 py-1.5 text-neutral-soft">{item.label}</span>
			{:else}
				{@render menuItem(item)}
			{/if}
		{/each}
	</Flex>

</Flex>



{#snippet menuItem(item)}
	<Inline as="li" class="page-menu-item">
		<svelte:element this={item.href ? 'a' : 'button'}
			class="{cx.item} {item.theme == "danger" ? cx.itemDanger : cx.itemDefault} {item.active || $url.hash === item.href ? cx.itemActive : ''}"
		{...item}>
			{#if item.icon}
				<Icon name={item.icon} size="md" />
			{/if}

			<div class="font-style-regular flex-shrink truncate">
				{#if item.label}
					{item.label}
				{/if}
			</div>

			{#if item.active || $url.hash === item.href}
				<Icon name="CaretRight" size="sm" class="ml-auto" />
			{/if}
		</svelte:element>
	</Inline>
{/snippet}