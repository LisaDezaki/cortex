<script>
	import { Link, page } from '@inertiajs/svelte'
    import clsx from 'clsx'
	
	import { Inline, Stack } from '@/Components/Core'
	import Heading      from '@/Components/UI/Heading.svelte'
	import Icon      from '@/Components/UI/Icon.svelte'
	import Input     from '@/Components/UI/Input'
	import url from '@/stores/urlStore'

    let {
		backTo,
		backToLabel = "Back",
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
		menu: clsx('page-menu sticky top-0 flex-none min-w-48 w-48 max-w-48 rounded-lg overflow-y-auto pr-2', className),
		back: clsx('border border-neutral-softest flex items-center gap-3 mb-3 place-self-start pl-3 pr-5 py-1.5 rounded-full hover:border-accent hover:text-accent'),
		item: clsx('page-menu-item flex items-center gap-3 p-1.5 pl-3 rounded w-full'),
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



<Stack class={cx.menu} {...restProps}>

	{#if backTo}
		<Link class={cx.back} href={backTo}>
			<Icon name="ArrowElbowUpLeft" size="md" />
			<span>{backToLabel}</span>
		</Link>
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

	<Stack as="ul" class="page-menu-list">
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
	</Stack>

</Stack>



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