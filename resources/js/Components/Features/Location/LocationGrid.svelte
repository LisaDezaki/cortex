<script>
	import { route } from 'momentum-trail'

	import Grid    from '@/Components/Core/Grid.svelte'
    // import Card    from '@/Components/UI/Card.svelte'
    import Heading from '@/Components/UI/Heading.svelte'
	import LocationCard from '@/Components/Features/Location/LocationCard.svelte'

	let {
		children,
		class: className,
		cols,
		gridItem,
		locations,
		regions,
		byRegion = false,
		...restProps
	} = $props()

</script>



<Grid
	class="w-full {className}"
	cols={cols}
	gap={2}
{...restProps}>
	{#if locations}
		{#each locations as location}
			{#if gridItem}
				{@render gridItem(location)}
			{:else}
				<LocationCard {location} />
			{/if}
		{/each}
	{:else if children}
		{@render children()}
	{/if}
</Grid>