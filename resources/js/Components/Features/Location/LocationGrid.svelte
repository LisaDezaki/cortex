<script>
	import { route } from 'momentum-trail'

	import Grid    from '@/Components/Core/Grid.svelte'
    // import Card    from '@/Components/UI/Card.svelte'
    import Heading from '@/Components/UI/Heading.svelte'
	import LocationCard from '@/Components/Features/Location/LocationCard.svelte'

	let {
		class: className,
		cols,
		gridItem,
		locations,
		regions,
		byRegion = false,
		...restProps
	} = $props()

	function edit(location) {
		if (onEdit) {
			onEdit(location)
		}
	}

	function destroy(location) {
		if (onDelete) {
			onDelete(location)
		}
	}

</script>

{#if byRegion}
	{#each regions as region}

		<Heading heading={region.name} is="h5" as="h6" />
		<Grid class="mb-6 {className}" {...restProps}>
			{#each locations.filter(l => l.region?.id == region.id) as location}
				<LocationCard {location} />
			{/each}
			{#snippet empty()}
				<p class="font-style-placeholder">No locations found in this region.</p>
			{/snippet}
		</Grid>
		
	{/each}
{:else}

	<Grid
		class={className}
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
		{/if}
	</Grid>

{/if}