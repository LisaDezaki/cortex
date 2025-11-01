<script>

	import { Link } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Form      from '@/Components/Core/Form.svelte'
	import Inline    from '@/Components/Core/Inline.svelte'
	import Button    from '@/Components/UI/Button.svelte'
	import Table     from '@/Components/UI/Table'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	import CharacterIcon from '@/Components/Features/Character/CharacterIcon.svelte'

    let {
		class: className,
		locations,
		selected = [],
		selectionMode,
		...restProps
	} = $props()

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
	<Table.Head sortable class="font-style-button">Name</Table.Head>
	<Table.Head sortable class="font-style-button">Type</Table.Head>
	<Table.Head sortable class="font-style-button">Regulars</Table.Head>
{/snippet}

{#snippet bodyRow(location)}
	{#if selectionMode}
		<Table.Cell shrink>
			<Form.Checkbox checked={selected.includes(location.id)} onclick={() => selectRow(location.id)} />
		</Table.Cell>
	{/if}
	<Table.Cell>
		<Link href={route('locations.show', {location: location.slug})} class="flex items-center gap-2 w-full hover:text-emerald-500">
			<Thumbnail
				class="h-6 w-9 rounded"
				icon="MapPinArea"
				src={location.image?.url}
			/>
			<div class="-space-y-0.5">
				<div class="font-style-small line-clamp-1">{location.name}</div>
				<div class="font-style-tiny line-clamp-1 opacity-65">{location.region?.name}</div>
			</div>
		</Link>
	</Table.Cell>
	<Table.Cell>
		<div class="font-style-small line-clamp-1">{location.type}</div>
	</Table.Cell>
	<Table.Cell>
		{#if location.mapItems.characters?.length > 0}
			<Inline gap={0.5} class="w-full">
				{#each location.mapItems.characters as mapItem, i}
					<Thumbnail
						class="h-7 w-7 rounded-full"
						href={route('characters.show', {character: mapItem.mappable?.slug})}
						icon="User" iconSize="sm"
						src={mapItem.mappable?.image?.url}
					/>
				{/each}
			</Inline>
		{/if}
	</Table.Cell>
{/snippet}



<Table
	class="w-full {className}"
	data={locations}
	{headRow}
	{bodyRow}
{...restProps} />