<script>
	import { Link } from '@inertiajs/svelte'
	
	import { Box, Inline, Stack } from '@/Components/Core'
	import Icon      from '@/Components/UI/Icon.svelte'
	import Input     from '@/Components/UI/Input.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

    let {
		children,
		class: className,
		items,
        ...restProps
    } = $props()

	let query = $state('')

</script>





{#snippet menuItem(item)}
	<Inline as="li" class="page-menu-item">
		<Link class="flex items-center gap-3 px-3 py-1.5 rounded w-full hover:bg-neutral-softest {item.active ? 'text-accent' : ''}" active={item.active} href={item.href} preserveScroll>
			
			<Icon name={item.icon} size="md" />

			<div class="font-style-regular flex-shrink truncate">
				{#if item.label}
					{item.label}
				{/if}
			</div>

			<!-- {#if item.active}
				<Icon class="flex-shrink-0 ml-auto" name="ArrowRight" size="sm" />
			{/if} -->

		</Link>
	</Inline>
{/snippet}

<Box class="sticky top-6 place-self-start {className}">
	<Stack class="page-menu min-w-48 py-2 rounded-lg" {...restProps}>
	
		{#if restProps.searchable}
			<div class="flex-shrink-0 px-1.5">
				<Input type="search"
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
				{@render menuItem(item)}
			{/each}
		</Stack>
	
	</Stack>
</Box>