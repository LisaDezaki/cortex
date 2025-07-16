<script>

	import { Link } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import CardGrid from '@/Components/CardGrid.svelte'
	import CharacterIcon from '@/Components/CharacterIcon.svelte'
	import FactionIcon from '@/Components/FactionIcon.svelte'
	import DataCell from '@/Components/DataCell.svelte'
	import Form from '@/Components/Form'
	import Table from '@/Components/Table'
	import Thumbnail from '@/Components/Thumbnail.svelte'

    let {
		factions,
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

<!-- <pre>{JSON.stringify(factions, null, 4)}</pre> -->

{#snippet headRow()}
	{#if selectionMode}
		<Table.Head shrink><Form.Checkbox onclick={selectAll} /></Table.Head>
	{/if}
	<Table.Head sortable class="font-style-button">Name</Table.Head>
	<Table.Head sortable class="font-style-button">Members</Table.Head>
	<Table.Head sortable class="font-style-button">Headquarters</Table.Head>
{/snippet}

{#snippet bodyRow(faction)}

	{#if selectionMode}
		<Table.Cell shrink><Form.Checkbox checked={selected.includes(faction.id)} onclick={() => selectRow(faction.id)} /></Table.Cell>
	{/if}
	<Table.Cell>
		<Link href={route('factions.show', {faction: faction.slug})} class="flex items-center gap-2 w-full hover:text-emerald-500">
			<Thumbnail
				class="h-9 w-9"
				src={faction.image_path}
				icon="FlagBannerFold"
			/>
			<div class="-space-y-0.5">
				<div class="font-style-regular">{faction.name}</div>
				<div class="font-style-tiny opacity-65 line-clamp-1">{faction.members.length} member{faction.members.length != 1 ? 's' : ''}</div>
			</div>
		</Link>
	</Table.Cell>
	<Table.Cell>
		{#if faction.members.length > 0}
			<div class="w-full -space-x-3">
				{#each faction.members as member, i}
					<CharacterIcon
						href={route('characters.show', {character: member.slug})}
						src={member.image_path}
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
		{#if faction.headquarters}
			<Link href={route('locations.show', {location: faction.headquarters.slug})} class="flex items-center gap-2 w-full hover:text-emerald-500">
				<Thumbnail
					class="h-9 w-9"
					src={faction.headquarters.image_path}
					icon="MapPin"
				/>
				<div class="-space-y-0.5">
					<div class="font-style-regular">{faction.headquarters.name}</div>
					<div class="font-style-tiny opacity-65 line-clamp-1">{faction?.headquarters?.region?.name}</div>
				</div>
			</Link>
		{:else}
			<Button
				class="bg-emerald-500/20 rounded-lg w-9 border border-emerald-500/30 text-emerald-500 hover:bg-emerald-500/30 hover:border-emerald-500/40"
				icon="Plus"
			/>
		{/if}
	</Table.Cell>
{/snippet}

<Table data={factions} {headRow} {bodyRow} />