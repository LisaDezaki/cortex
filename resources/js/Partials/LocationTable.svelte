<script>

	import { Link } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import CharacterIcon from '@/Components/CharacterIcon.svelte'
	import Form from '@/Components/Form.svelte'
	import Table from '@/Components/Table'
	import Thumbnail from '@/Components/Thumbnail.svelte'

    let {
		locations,
		selected = [],
		selectionMode
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
				class="h-8 w-12 rounded"
				icon="MapPin"
				src={location.banner?.url}
			/>
			<div class="-space-y-0.5">
				<div class="font-style-regular line-clamp-1">{location.name}</div>
				<div class="font-style-tiny line-clamp-1 opacity-65">{location.region?.name}</div>
			</div>
		</Link>
	</Table.Cell>
	<Table.Cell>
		{#if location.characters.length > 0}
			<div class="w-full -space-x-3">
				{#each location.characters as character, i}
					<CharacterIcon
						href={route('characters.show', {character: character.slug})}
						src={character.portrait?.url}
					/>
				{/each}
			</div>
		{/if}
	</Table.Cell>
{/snippet}

<Table data={locations} {headRow} {bodyRow} />

<!-- <Table>
	<Table.Row>
		{#if selectionMode}
			<Table.Head shrink><Form.Checkbox onclick={selectAll} /></Table.Head>
		{/if}
		<Table.Head sortable class="font-style-button">Name</Table.Head>
		<Table.Head sortable class="font-style-button">Regulars</Table.Head>
	</Table.Row>
	{#each locations as location}
		<Table.Row>
			{#if selectionMode}
				<Table.Cell shrink><Form.Checkbox checked={selected.includes(location.id)} onclick={() => selectRow(location.id)} /></Table.Cell>
			{/if}
			<Table.Cell>
				<DataCell
					class="w-full"
					href={route('locations.show', {location: location.slug})}
					image={location.image_path}
					icon="MapPin"
					title={location.name}
					subtitle={location.region?.name}
				/>
			</Table.Cell>
			<Table.Cell>
				{#if location.characters.length > 0}
					<div class="w-full -space-x-3">
						{#each location.characters as character, i}
							<CharacterIcon
								href={route('characters.show', {character: character.slug})}
								src={character.image_path}
							/>
						{/each}
					</div>
				{/if}
			</Table.Cell>
		</Table.Row>
	{/each}
</Table> -->