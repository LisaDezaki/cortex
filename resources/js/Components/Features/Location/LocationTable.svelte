<script>

	import { Link } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Form      from '@/Components/Core/Form.svelte'
	import Inline    from '@/Components/Core/Inline.svelte'
	import Button    from '@/Components/UI/Button.svelte'
	import Table     from '@/Components/UI/Table'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

    let {
		class: className,
		locations = [],
		selected = [],
		selectionMode,
		...restProps
	} = $props()

	let columns = $state(['name', 'items'])

	function selectAll() {
		// if (selected.length == characters.length) {
		// 	selected = []
		// } else {
		// 	characters.each(c => { selected.push(c.id)})
		// 	// selected = characters.map(c => c.id)
		// }
	}

	function selectRow(id) {
		if (selected.includes(id)) {
			let i = selected.indexOf(id)
			selected.splice(i,1)
		} else {
			selected.push(id)
		}
	}

</script>

{#snippet headRow()}
	{#if selectionMode}
		<Table.Head shrink><Form.Checkbox onclick={selectAll} /></Table.Head>
	{/if}
	<Table.Head sortable class="max-w-64">Name</Table.Head>
	<Table.Head sortable class="max-w-40">Type</Table.Head>
	<Table.Head sortable class="max-w-64">Regulars</Table.Head>
{/snippet}

{#snippet bodyRow(location)}
	{#if selectionMode}
		<Table.Cell shrink>
			<Form.Checkbox checked={selected.includes(location.id)} onclick={() => selectRow(location.id)} />
		</Table.Cell>
	{/if}
	<Table.Cell class="inline-flex items-center gap-0.5 py-0.5 max-w-64">
		<Link href={route('locations.show', {location: location.slug})} class="flex items-center gap-2 w-full hover:text-emerald-500">
			<Thumbnail
				class="bg-neutral-softest h-6 w-9 rounded"
				src={location.image?.url}
			/>
			<Inline>{location.name}</Inline>
		</Link>
	</Table.Cell>
	<Table.Cell class="inline-flex items-center gap-0.5 py-0.5 max-w-40">
		<div class="font-style-small line-clamp-1">{location.type}</div>
	</Table.Cell>
	<Table.Cell class="inline-flex items-center gap-0.5 py-0.5 max-w-64">
		{#if location.mapItems.characters?.length > 0}
			{#each location.mapItems.characters as mapItem, i}
				<Thumbnail
					class="bg-neutral-softest h-6 w-6 rounded"
					href={route('characters.show', {character: mapItem.mappable?.slug})}
					src={mapItem.mappable?.image?.url}
				/>
			{/each}
		{/if}
	</Table.Cell>
{/snippet}



<Table
	class="w-full {className}"
	data={locations}
	{headRow}
	{bodyRow}
{...restProps} />