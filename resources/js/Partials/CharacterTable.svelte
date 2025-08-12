<script>

	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Button        from '@/Components/UI/Button.svelte'
	import Form          from '@/Components/Core/Form.svelte'
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

	let filters 	= $state([{}])
	let rowSize 	= $state(6)
	let sortBy  	= $state(null)
	let reverseSort = $state(false)
	let columns     = $state(['name', 'faction', 'relationships', 'location'])

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

	function addFilter() {
		filters.push({})
	}

	function removeFilter(index) {
		filters.splice(index,1)
	}

	function removeAllFilters() {
		filters = [{}]
	}

	

</script>

<div class="flex gap-3">

	<!-- Filter -->

	<!-- <div class="flex gap-1.5">
		<Button icon="Funnel" iconSize={24} onclick={removeAllFilters} />
		{#each filters as filter, i}
			<CharacterFilter bind:filter={filters[i]} onremove={() => removeFilter(i)} />
		{/each}
	</div> -->

	<!-- Sort -->

	<!-- <div class="flex gap-3">
		<Form.Select class="max-w-40 ml-auto" placeholder={"Sort by"} bind:value={sortBy} options={[
			{ value: 'name',  label: "Name" },
			{ value: 'numRelationships', label: "Number of Relationships" },
			{ value: 'location', label: "Location name" },
			{ value: 'faction',  label: "Faction name" },
			{ value: 'created-at', label: "Date Created" },
			{ value: 'updated-at', label: "Date Updated" },
		]} />
	</div> -->

	<!-- Advanced -->

	<!-- <Button style="plain" theme="accent"
		label="Advanced filters"
	/> -->

	<!-- Columns -->

	<!-- <div class="flex justify-between gap-3 ml-auto">
		<Form.Select class="ml-auto" type="multiple" overrideLabel="Columns" bind:value={columns} options={[
			{ value: 'faction',       label: "Faction" },
			{ value: 'relationships', label: "Relationships" },
			{ value: 'location',      label: "Location" },
			...customFields.map((field) => {
				return { value: field.name, label: field.label }
			})
		]} />
	</div> -->
</div>

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
				class="h-9 w-9 rounded-full"
				src={character.portrait?.url}
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
						class="h-9 w-9"
						src={character?.factions[0]?.emblem?.url}
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
					class="h-9 w-9 rounded-lg"
				/>
			{/if}
		</Table.Cell>
	{/if}
	{#if columns.includes('relationships')}
		<Table.Cell>
			{#if character?.relationships.length > 0}
				<div class="w-full -space-x-3">
					{#each character?.relationships as relationship, i}
						<CharacterIcon
							href={route('characters.show', {character: relationship?.slug})}
							src={relationship?.portrait?.url}
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
	{/if}
	{#if columns.includes('location')}
		<Table.Cell>
			{#if character?.location}
				<Link href={route('locations.show', {location: character.location.slug})} class="flex items-center gap-2 w-full hover:text-emerald-500">
					<Thumbnail
						class="h-9 w-9"
						src={character.location.banner?.url}
						icon="MapPin"
					/>
					<div class="-space-y-0.5">
						<div class="font-style-regular line-clamp-1">{character?.location.name}</div>
						<div class="font-style-tiny line-clamp-1 opacity-65">{character?.location.region?.name}</div>
					</div>
				</Link>
			{:else}
				<Button style="soft" theme="accent"
					icon="Plus" iconSize={20} iconWeight="light"
					class="h-9 w-9 rounded-lg"
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