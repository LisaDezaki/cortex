<script>

	import { Link } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Form          from '@/Components/Core/Form.svelte'
	import Button        from '@/Components/UI/Button.svelte'
	import Table         from '@/Components/UI/Table'
	import Thumbnail     from '@/Components/UI/Thumbnail.svelte'
	import CharacterIcon from '@/Components/Features/Character/CharacterIcon.svelte'

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
		<Table.Cell shrink>
			<Form.Checkbox checked={selected.includes(faction.id)} onclick={() => selectRow(faction.id)} />
		</Table.Cell>
	{/if}
	<Table.Cell>
		<Link href={route('factions.show', {faction: faction.slug})} class="flex items-center gap-2 w-full hover:text-emerald-500">
			<Thumbnail
				class="h-9 w-9"
				src={faction.emblem?.url}
				icon="FlagBannerFold"
			/>
			<div class="-space-y-0.5">
				<div class="font-style-regular">{faction.name}</div>
				<div class="font-style-tiny line-clamp-1 opacity-65">{faction.members.length} member{faction.members.length != 1 ? 's' : ''}</div>
			</div>
		</Link>
	</Table.Cell>
	<Table.Cell>
		{#if faction.members.length > 0}
			<div class="flex w-full">
				{#each faction.members as member, i}
					<CharacterIcon
						class="outline-emerald-500 outline-offset-2 hover:outline outline-1 {i !== 0 ? "-ml-3 " : ""}"
						href={route('characters.show', {character: member.slug})}
						src={member.portrait?.url}
					/>
				{/each}
			</div>
		{:else}
			<Button style="soft" theme="accent"
				icon="Plus" iconSize={20} iconWeight="light"
				class="h-9 w-9 rounded-full"
			/>
		{/if}
	</Table.Cell>
	<Table.Cell>
		{#if faction.headquarters}
			<Link href={route('locations.show', {location: faction.headquarters.slug})} class="flex items-center gap-2 w-full hover:text-emerald-500">
				<Thumbnail
					class="h-9 w-9"
					src={faction.headquarters.banner?.url}
					icon="MapPinArea"
				/>
				<div class="-space-y-0.5">
					<div class="font-style-regular line-clamp-1">{faction.headquarters.name}</div>
					<div class="font-style-tiny line-clamp-1 opacity-65">{faction?.headquarters?.region?.name}</div>
				</div>
			</Link>
		{:else}
			<Button style="soft" theme="accent"
				icon="Plus" iconSize={20} iconWeight="light"
				class="h-9 w-9"
			/>
		{/if}
	</Table.Cell>
{/snippet}

<Table data={factions} {headRow} {bodyRow} />