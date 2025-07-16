<script>

	import { Link } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Avatar from '@/Components/Avatar.svelte'
	import Button from '@/Components/Button.svelte'
	import CharacterIcon from '@/Components/CharacterIcon.svelte'
	import DataCell from '@/Components/DataCell.svelte'
	import Form from '@/Components/Form'
	import Table from '@/Components/Table'
	import Thumbnail from '@/Components/Thumbnail.svelte'

    let {
		characters,
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

<!-- <pre>{JSON.stringify(characters, null, 4)}</pre> -->

{#snippet headRow()}
	{#if selectionMode}
		<Table.Head shrink><Form.Checkbox onclick={selectAll} /></Table.Head>
	{/if}
	<Table.Head sortable class="font-style-button">Name</Table.Head>
	<Table.Head sortable class="font-style-button">Factions</Table.Head>
	<Table.Head sortable class="font-style-button">Relationships</Table.Head>
	<Table.Head sortable class="font-style-button">Locations</Table.Head>
{/snippet}

{#snippet bodyRow(character)}
	{#if selectionMode}
		<Table.Cell shrink>
			<Form.Checkbox checked={selected.includes(character.id)} onclick={() => selectRow(character.id)} />
		</Table.Cell>
	{/if}
	<Table.Cell>
		<Link href={route('characters.show', {character: character.slug})} class="flex items-center gap-2 w-full hover:text-emerald-500">
			<Thumbnail
				class="h-9 w-9 rounded-full"
				src={character.image_path}
				icon="User"
			/>
			<div class="-space-y-0.5">
				<div class="font-style-regular">{character.name}</div>
				<div class="font-style-tiny opacity-65 line-clamp-1">{character.subtitle}</div>
			</div>
		</Link>
	</Table.Cell>
	<Table.Cell>
		{#if character?.factions.length > 0}
			<Link href={route('factions.show', {faction: character?.factions[0]?.slug})} class="flex items-center gap-2 w-full hover:text-emerald-500">
				<Thumbnail
					class="h-9 w-9"
					src={character?.factions[0]?.image_path}
					icon="FlagBannerFold"
				/>
				<div class="-space-y-0.5">
					<div class="font-style-regular">{character?.factions[0]?.name}</div>
					<div class="font-style-tiny opacity-65 line-clamp-1">{character?.factions[0]?.members?.length} member{character?.factions[0]?.members?.length !== 1 ? 's' : ''}</div>
				</div>
			</Link>
		{:else}
			<Button
				class="bg-emerald-500/20 rounded-lg w-8 border border-emerald-500/30 text-emerald-500 hover:bg-emerald-500/30 hover:border-emerald-500/40"
				icon="Plus"
			/>
		{/if}
	</Table.Cell>
	<Table.Cell>
		{#if character?.relationships.length > 0}
			<div class="w-full -space-x-3">
				{#each character?.relationships as relationship, i}
					<CharacterIcon
						href={route('characters.show', {character: relationship?.slug})}
						src={relationship?.image_path}
					/>
				{/each}
			</div>
		{:else}
			<Button
				class="bg-emerald-500/20 rounded-full w-9 aspect-square border border-emerald-500/30 text-emerald-500 hover:bg-emerald-500/30 hover:border-emerald-500/40"
				icon="Plus"
			/>
		{/if}
	</Table.Cell>
	<Table.Cell>
		{#if character?.location}
			<Link href={route('locations.show', {location: character.location.slug})} class="flex items-center gap-2 w-full hover:text-emerald-500">
				<Thumbnail
					class="h-9 w-9"
					src={character.location.image_path}
					icon="MapPin"
				/>
				<div class="-space-y-0.5">
					<div class="font-style-regular line-clamp-1">{character?.location.name}</div>
					<div class="font-style-tiny opacity-65 line-clamp-1">{character?.location.region?.name}</div>
				</div>
			</Link>
		{:else}
			<Button
				class="bg-emerald-500/20 rounded-lg w-8 border border-emerald-500/30 text-emerald-500 hover:bg-emerald-500/30 hover:border-emerald-500/40"
				icon="Plus"
			/>
		{/if}
	</Table.Cell>
{/snippet}

<Table data={characters} {headRow} {bodyRow} />