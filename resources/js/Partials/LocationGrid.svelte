<script>
	import { route } from 'momentum-trail'

    import Card from '@/Components/Card.svelte'
    import CardGrid from '@/Components/CardGrid.svelte'
    import Heading from '@/Components/Heading.svelte'

	let {
		class: className,
		locations,
		onEdit,
		onDelete,
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
		<CardGrid items={locations.filter(l => l.region?.id == region.id)} class="mb-6{className}" {...restProps}>
			{#snippet card(location)}
				<Card aspect="video"
					icon="MapPin"
					image={location.banner?.url}
					title={location.name}
					subtitle={location.region?.name}
					href={route('locations.show', {location: location.slug})}
					options={[
						{ icon: 'Pencil', theme: 'neutral', onclick: edit,    label: 'Edit Location'   },
						{ icon: 'Trash',  theme: 'danger',  onclick: destroy, label: 'Delete Location' }
					]}
				/>
			{/snippet}
			{#snippet empty()}
				<p class="font-style-placeholder">No locations found in this region.</p>
			{/snippet}
		</CardGrid>
	{/each}
{:else}
	<CardGrid items={locations} class={className} {...restProps}>
		{#snippet card(location)}
			<Card
				aspect="video"
				image={location.banner?.url}
				icon="MapPin"
				title={location.name}
				subtitle={location.region?.name}
				href={route('locations.show', {location: location.slug})}
				options={[
					{ icon: 'Pencil', theme: 'neutral', onclick: edit,    label: 'Edit Location'   },
					{ icon: 'Trash',  theme: 'danger',  onclick: destroy, label: 'Delete Location' }
				]}
			/>
		{/snippet}
	</CardGrid>
{/if}