<script>

	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Form          from '@/Components/Core/Form.svelte'
	import Inline        from '@/Components/Core/Inline.svelte'
	import Button        from '@/Components/UI/Button.svelte'
	import Table         from '@/Components/UI/Table'
	import Thumbnail     from '@/Components/UI/Thumbnail.svelte'
	
	let customFields = $page.props.customFields?.data

    let {
		class: className,
		factions = [],
		selected = [],
		selectionMode
	} = $props()

	let columns = $state(['name', 'members', 'headquarters'])

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
	<Table.Head sortable class="max-w-60">Name</Table.Head>
	<Table.Head sortable class="max-w-40">Members</Table.Head>
	<Table.Head sortable class="max-w-52">Headquarters</Table.Head>
{/snippet}

{#snippet bodyRow(faction)}

	{#if selectionMode}
		<Table.Cell shrink>
			<Form.Checkbox checked={selected.includes(faction.id)} onclick={() => selectRow(faction.id)} />
		</Table.Cell>
	{/if}
	<Table.Cell class="max-w-60">
		<Link class="flex items-center gap-1.5 py-0.5 hover:text-emerald-500" href={route('factions.show', {faction: faction.slug})}>
			<Thumbnail
				class="bg-neutral-softest h-6 w-6 rounded"
				src={faction.image?.url}
			/>
			<Inline>{faction.name}</Inline>
		</Link>
	</Table.Cell>
	<Table.Cell class="flex items-center gap-0.5 py-0.5 max-w-40">
		{#if faction.members.items.length > 0}
			{#each faction.members.items as member, i}
				<Link href={route('characters.show', {character: member.slug})} class="flex items-center gap-1 hover:text-emerald-500">
					<Thumbnail
						class="bg-neutral-softest h-6 w-6 rounded"
						src={member.image?.url}
					/>
					<!-- <Inline>{member.name}</Inline> -->
				</Link>
			{/each}
		{:else}
			<Button size="sm" style="soft" theme="accent"
				icon="Plus" class="h-6 w-6 rounded"
			/>
		{/if}
	</Table.Cell>
	<Table.Cell class="flex items-center gap-1.5 py-0.5 max-w-52">
		{#if faction.headquarters}
			<Link href={route('locations.show', {location: faction.headquarters.slug})} class="flex items-center gap-1 hover:text-emerald-500">
				<Thumbnail
					class="bg-neutral-softest h-6 w-6 rounded"
					src={faction.headquarters.image?.url}
				/>
				<Inline>{faction.headquarters.name}</Inline>
			</Link>
		{:else}
			<Button size="sm" style="soft" theme="accent"
				icon="Plus" class="h-6 w-6 rounded"
			/>
		{/if}
	</Table.Cell>
{/snippet}

<Table
	class="w-full {className}"
	data={factions}
	{headRow} {bodyRow}
/>