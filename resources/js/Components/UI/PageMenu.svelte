<script>
	import { Link } from '@inertiajs/svelte'
	
	import { Box, Inline, Stack } from '@/Components/Core'
	import Button      from '@/Components/UI/Button.svelte'
	import Icon      from '@/Components/UI/Icon.svelte'
	import Input     from '@/Components/UI/Input.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

    let {
		backTo,
		backToLabel = "Back",
		children,
		class: className,
		items,
        ...restProps
    } = $props()

	let query = $state('')

</script>





{#snippet menuItem(item)}
	<Inline as="li" class="page-menu-item">
		<svelte:element this={item.href ? 'a' : 'button'}
			class="flex items-center gap-3 px-3 py-1.5 rounded w-full {item.theme == "danger" ? 'hover:bg-danger-softest' : 'hover:bg-neutral-softest'}"
			class:text-accent={item.active}
			class:text-danger={item.theme == "danger"}
		{...item}>
			<Icon name={item.icon} size="md" />

			<div class="font-style-regular flex-shrink truncate">
				{#if item.label}
					{item.label}
				{/if}
			</div>
		</svelte:element>
	</Inline>
{/snippet}

<Box class="sticky top-0 place-self-start {className}">
	<Stack class="page-menu min-w-48 rounded-lg" {...restProps}>

		{#if backTo}
			<Link href={backTo} class="place-self-start border border-neutral-softest flex items-center gap-3 mb-3 pl-3 pr-5 py-1.5 rounded-full hover:border-accent hover:text-accent">
				<Icon name="ArrowElbowUpLeft" size="md" />
				<span>{backToLabel}</span>
			</Link>
		{/if}
	
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