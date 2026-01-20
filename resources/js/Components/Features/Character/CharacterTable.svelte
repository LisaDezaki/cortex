<script>

	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Flex          from '@/Components/Core/Flex.svelte'
	import Form          from '@/Components/Core/Form.svelte'
	import Inline        from '@/Components/Core/Inline.svelte'
	import Button        from '@/Components/UI/Button.svelte'
	import Icon          from '@/Components/UI/Icon.svelte'
	import Table         from '@/Components/UI/Table'
	import Thumbnail     from '@/Components/UI/Thumbnail.svelte'

	let customFields = $page.props.customFields?.data

    let {
		class: className,
		characters = [],
		selected = [],
		selectionMode,
		...restProps
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
	<Table.Head sortable class="max-w-32">Name</Table.Head>
	{#if columns.includes('faction')}
		<Table.Head sortable>Faction</Table.Head>
	{/if}
	{#if columns.includes('relationships')}
		<Table.Head sortable>Relationships</Table.Head>
	{/if}
	{#if columns.includes('location')}
		<Table.Head sortable>Location</Table.Head>
	{/if}
	{#each customFields as field}
		{#if columns.includes(field.name)}
			<Table.Head sortable>{field.label}</Table.Head>
		{/if}
	{/each}
{/snippet}

{#snippet bodyRow(character)}
	{#if selectionMode}
		<Table.Cell shrink>
			<Form.Checkbox checked={selected.includes(character.id)} onclick={() => selectRow(character.id)} />
		</Table.Cell>
	{/if}
	<Table.Cell class="max-w-32">
		<Link class="flex items-center gap-1.5 py-0.5 hover:text-emerald-500" href={route('characters.show', {character: character.slug})}>
			<Thumbnail
				class="bg-neutral-softest h-6 rounded w-6"
				src={character.image?.url}
			/>
			<Inline>{character.name}</Inline>
		</Link>
	</Table.Cell>
	{#if columns.includes('faction')}
		<Table.Cell class="flex items-center gap-1.5 py-0.5">
			{#if character?.factions?.items.length > 0}
				{#each character?.factions?.items as faction}
					<Link href={route('factions.show', {faction: faction.slug})} class="flex items-center gap-2 hover:text-emerald-500">
						<Thumbnail
							class="bg-neutral-softest h-6 w-6 rounded"
							src={faction.image?.url}
						/>
						<Inline>{faction.name}</Inline>
					</Link>
				{/each}
			{:else}
				<Button size="sm" style="soft" theme="accent"
					icon="Plus" iconSize="sm" iconWeight="light"
					class="h-6 w-6 rounded"
					onclick={() => character.addFaction()}
				/>
			{/if}
		</Table.Cell>
	{/if}
	{#if columns.includes('relationships')}
		<Table.Cell class="flex items-center gap-1.5 py-0.5">
			{#if character?.relationships?.items.length > 0}
				<Flex align="center" gap={1} class="h-full w-full">
					{#each character?.relationships?.items as relationship, i}
						<Link href={route('characters.show', {character: relationship?.slug})} class="flex items-center">
							<Thumbnail
								class="bg-neutral-softest h-6 w-6 rounded"
								src={relationship?.image?.url}
							/>
						</Link>
					{/each}
				</Flex>
			{:else}
				<Button size="sm" style="soft" theme="accent"
					icon="Plus" iconSize="sm" iconWeight="light"
					class="h-6 w-6 rounded"
					onclick={() => character.openModal('relationship')}
				/>
			{/if}
		</Table.Cell>
	{/if}
	{#if columns.includes('location')}
		<Table.Cell class="flex items-center gap-1.5 py-0.5">
			{#if character?.location}
				<Link href={route('locations.show', {location: character.location.slug})} class="flex items-center gap-2 w-full hover:text-emerald-500">
					<Thumbnail
						class="bg-neutral-softest h-6 w-6 rounded"
						src={character.location.image?.url}
					/>
					<div class="-space-y-0.5">
						<div class="font-style-small line-clamp-1">{character?.location.name}</div>
						<div class="font-style-tiny line-clamp-1 opacity-65">{character?.location.region?.name}</div>
					</div>
				</Link>
			{:else}
				<Button size="sm" style="soft" theme="accent"
					icon="Plus" iconSize="sm" iconWeight="light"
					class="h-6 w-6 rounded"
					onclick={() => character.openModal('location')}
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

<Table
	class="w-full {className}"
	data={characters}
	{headRow} {bodyRow}
/>