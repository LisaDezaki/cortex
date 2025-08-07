<script>
	import { route } from 'momentum-trail'

    import Card from '@/Components/Card.svelte'
    import CardGrid from '@/Components/CardGrid.svelte'

	let {
		class: className,
		locations,
		regions,
		...restProps
	} = $props()

</script>

{#if regions}
	{#each regions as region}
		<CardGrid items={region.locations} class={className} {...restProps}>
			{#snippet card(location)}
				<Card
					class="aspect-video"
					icon="MapPin"
					image={location.banner?.url}
					title={location.name}
					href={route('locations.show', {location: location.slug})}
				/>
			{/snippet}
		</CardGrid>
	{/each}
{:else}
	<CardGrid items={locations} class={className} {...restProps}>
		{#snippet card(location)}
			<Card
				class="aspect-video"
				image={location.banner?.url}
				icon="MapPin"
				title={location.name}
				href={route('locations.show', {location: location.slug})}
			/>
		{/snippet}
	</CardGrid>
{/if}