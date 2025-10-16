<script>

	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Flex          from '@/Components/Core/Flex.svelte'
	import Form          from '@/Components/Core/Form.svelte'
	import Button        from '@/Components/UI/Button.svelte'
	import Icon          from '@/Components/UI/Icon.svelte'
	import Table         from '@/Components/UI/Table'
	import Thumbnail     from '@/Components/UI/Thumbnail.svelte'

	import CharacterIcon from '@/Components/Features/Character/CharacterIcon.svelte'

	let customFields = $page.props.customFields?.data

    let {
		characters,
		selected = [],
		selectionMode
	} = $props()

	let columns = $state(['name', 'faction', 'relationships', 'location'])

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
	{#if columns.includes('faction')}
		<Table.Head sortable class="font-style-button">Faction</Table.Head>
	{/if}
	{#if columns.includes('relationships')}
		<Table.Head sortable class="font-style-button">Relationships</Table.Head>
	{/if}
	{#if columns.includes('location')}
		<Table.Head sortable class="font-style-button">Location</Table.Head>
	{/if}
	{#each customFields as field}
		{#if columns.includes(field.name)}
			<Table.Head sortable class="font-style-button">{field.label}</Table.Head>
		{/if}
	{/each}
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
				class="h-7 w-7 rounded-full"
				src={character.image?.url}
				icon="User"
			/>
			<div class="-space-y-0.5">
				<div class="font-style-regular line-clamp-1">{character.name}</div>
				<div class="font-style-tiny line-clamp-1 opacity-65">{character.subtitle}</div>
			</div>
		</Link>
	</Table.Cell>
	{#if columns.includes('faction')}
		<Table.Cell>
			{#if character?.factions.length > 0}
				<Link href={route('factions.show', {faction: character?.factions[0]?.slug})} class="flex items-center gap-2 w-full hover:text-emerald-500">
					<Thumbnail
						class="h-7 w-7"
						src={character?.factions[0]?.image?.url}
						icon="FlagBannerFold"
					/>
					<div class="-space-y-0.5">
						<div class="font-style-regular line-clamp-1">{character?.factions[0]?.name}</div>
						<div class="font-style-tiny line-clamp-1 opacity-65">{character?.factions[0]?.members?.length} member{character?.factions[0]?.members?.length !== 1 ? 's' : ''}</div>
					</div>
				</Link>
			{:else}
				<Button style="soft" theme="accent"
					icon="Plus" iconSize={20} iconWeight="light"
					class="h-7 w-7 rounded-lg"
					onclick={() => character.addFaction()}
				/>
			{/if}
		</Table.Cell>
	{/if}
	{#if columns.includes('relationships')}
		<Table.Cell>
			{#if character?.relationships.length > 0}
				<Flex class="w-full">
					{#each character?.relationships as relationship, i}
						<CharacterIcon
							class="bg-white -mr-4"
							href={route('characters.show', {character: relationship?.slug})}
							src={relationship?.image?.url}
						/>
					{/each}
				</Flex>
			{:else}
				<Button style="soft" theme="accent"
					icon="Plus" iconSize={20} iconWeight="light"
					class="h-7 w-7 rounded-full"
					onclick={() => character.addRelationship()}
				/>
			{/if}
		</Table.Cell>
	{/if}
	{#if columns.includes('location')}
		<Table.Cell>
			{#if character?.location}
				<Link href={route('locations.show', {location: character.location.slug})} class="flex items-center gap-2 w-full hover:text-emerald-500">
					<Thumbnail
						class="h-7 w-7"
						src={character.location.image?.url}
						icon="MapPinArea"
					/>
					<div class="-space-y-0.5">
						<div class="font-style-regular line-clamp-1">{character?.location.name}</div>
						<div class="font-style-tiny line-clamp-1 opacity-65">{character?.location.region?.name}</div>
					</div>
				</Link>
			{:else}
				<Button style="soft" theme="accent"
					icon="Plus" iconSize={20} iconWeight="light"
					class="h-7 w-7 rounded-lg"
					onclick={() => character.addLocation()}
				/>
			{/if}
		</Table.Cell>
	{/if}

	{#each customFields as field}
		{#if columns.includes(field.name)}
			<Table.Cell>
				{character.customFieldValues.find(f => f.customFieldId === field.id).value}
			</Table.Cell>
		{/if}
	{/each}
{/snippet}

<Table data={characters} {headRow} {bodyRow} />