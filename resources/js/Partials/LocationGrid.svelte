<script>
	import { route } from 'momentum-trail'

	import Grid    from '@/Components/Core/Grid.svelte'
    import Card    from '@/Components/UI/Card.svelte'
    import Heading from '@/Components/UI/Heading.svelte'

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
		<Grid class="mb-6 {className}" {...restProps}>
			{#each locations.filter(l => l.region?.id == region.id) as location}
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
			{/each}
			{#snippet empty()}
				<p class="font-style-placeholder">No locations found in this region.</p>
			{/snippet}
		</Grid>
	{/each}
{:else}
	<Grid class={className} {...restProps}>
		{#each locations as location}
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
		{/each}
	</Grid>
{/if}