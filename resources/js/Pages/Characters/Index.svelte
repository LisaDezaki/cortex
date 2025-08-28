<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharacterGrid  from '@/Partials/CharacterGrid.svelte'
	import CharacterTable from '@/Partials/CharacterTable.svelte'

	import { Flex, Stack } from '@/Components/Core'

	import Dropdown from '@/Components/UI/Dropdown.svelte'
	import Icon     from '@/Components/UI/Icon.svelte'
	import Input    from '@/Components/UI/Input.svelte'
	import PageHeader  from '@/Components/UI/PageHeader.svelte'
	import Section  from '@/Components/UI/Section.svelte'

	const activeProject = $page.props.activeProject.data
	const customFields  = $page.props.customFields?.data
	const characters    = activeProject?.characters
	const factions      = activeProject?.factions
	const locations     = activeProject?.locations

	let columns   = $state(['name', 'faction', 'relationships', 'location'])
	let filter    = $state('')
	let layout    = $state('grid')
	let query     = $state('')
	let rowSize   = $state(8)
	let sortBy    = $state('name')
	let sortOrder = $state('asc')

	let gridRows = $derived(16-rowSize)
	let hasFilter     = $derived(Boolean(filter))
	let characterList = $derived(
		characters
			.filter(c => {
				if (query.length > 0 && !c.name.toLowerCase().includes(query.toLowerCase())) { return false }
				if (filter === 'faction' && c.factions[0]?.name !== filter.value) { return false }
				if (filter === 'location' && c.location?.name !== filter.value) { return false }
				if (filter === 'relationship' && !c.relationships?.map(r => r.name).includes(filter.value)) { return false }
				if (!['Faction', 'Location', 'Relationship'].includes(filter.name) && filter.value && c.customFieldValues?.find(f => f.field?.label === filter.name)?.value !== filter.value) { return false }
				return true
			}).sort((a, b) => {
				if (sortBy === 'name')       { return a.name                 < b.name                 ? -1 : 1 }
				if (sortBy === 'alias')      { return a.alias                < b.alias                ? -1 : 1 }
				if (sortBy === 'popularity') { return a.relationships.length > b.relationships.length ? -1 : 1 }
				if (sortBy === 'faction')    { return a.factions?.[0]?.name  < b.factions?.[0]?.name  ? -1 : 1 }
				if (sortBy === 'location')   { return a.location?.name       < b.location?.name       ? -1 : 1 }
				if (sortBy === 'created_at') { return a.meta.createdAt       < b.meta.createdAt       ? -1 : 1 }
				if (sortBy === 'updated_at') { return a.meta.updatedAt       < b.meta.updatedAt       ? -1 : 1 }
				if (sortBy === 'random')     { return Math.random()          < 0.5                    ? -1 : 1 }
			})
	)
	let characterListSorted = $derived( sortOrder == 'asc' ? characterList : characterList.reverse())

	function mapToFilterItem(item) {
		return {
			label: (item.label || item.name),
			value: (item.slug || item.value)
		}
	}

</script>

<svelte:head>
    <title>Character List</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[]}
			back={route('dashboard')}
			title="Characters"
			actions={[
				{ icon: "Plus",     theme: "accent" },
				{ icon: "GearFine", theme: "neutral", href: route('characters.settings') },
			]}
		>
			<Flex align="start" gap={3}>

				<!-- Search -->

				<Input type="search" bind:value={query} class="w-48"
					icon="MagnifyingGlass" name="search" placeholder="Search..."
				/>
				
				<!-- Filter -->

				<Dropdown class="w-48" contentClass="w-48" icon="FunnelSimple" label="All characters" bind:value={filter} options={[
					{ label: 'Nameless',   value: 'noname' },
					{ label: 'Incomplete', value: 'incomplete' },
					{ separator: true },
					{ label: 'Faction...', children: factions.map(f => {
						return { label: f.name, value: `faction.${f.slug}`, image: f.emblem?.url }
					}) },
					{ label: 'Location...', children: locations.map(l => {
						return { label: l.name, value: `location.${l.slug}`, image: l.banner?.url }
					}) },
					{ label: 'Relationships...', children: characters.map(c => {
						return { label: c.name, value: `relationship.${c.slug}`, image: c.portrait?.url }
					}) },
					...customFields.filter(f => f.type == 'select').map(f => {
						return { label: `${f.label}...`, children: f.options.map(o => {
							return { label: o.label, value: `${f.name}.${o.value}` }
						})}
					})
				]} />

				<!-- Sort -->

				<Input type="select" class="w-48" icon="SortAscending" placeholder="Sort by" bind:value={sortBy} options={[
					{ value: 'name',       label: "By name" },
					{ value: 'alias',      label: "By alias" },
					{ value: 'popularity', label: "By popularity" },
					{ value: 'location',   label: "By location" },
					{ value: 'faction',    label: "By faction" },
					{ separator: true },
					{ value: 'created_at', label: "Date Created" },
					{ value: 'updated_at', label: "Date Updated" },
					{ value: 'random',     label: "Randomly" },
				]} />

				<!-- Result Count -->

				<div class="bg-emerald-500/10 text-emerald-500 rounded-lg p-2">{characterList.length} {characterList.length !== 1 ? 'results' : 'result'}</div>

				<!-- Layout-specific Controls -->

				<Flex gap={1.5} class="ml-auto min-w-40 flex-shrink-0">
					{#if layout === 'graph'}
						<Icon name="MagnifyingGlass" size="md" />
						<Input type="slider" style="none" class="" showValue={false} min={4} max={12} bind:value={rowSize} />
					{:else if layout === 'grid'}
						<Icon name="Resize" size="md" />
						<Input type="slider" style="none" class="" showValue={false} min={4} max={12} bind:value={rowSize} />
					{:else if layout === 'table'}
						<Input type="select" multiple
							class="ml-auto"
							overrideLabel="Columns..."
							bind:value={columns}
							options={[
								{ value: 'faction',       label: "Faction" },
								{ value: 'relationships', label: "Relationships" },
								{ value: 'location',      label: "Location" },
								...customFields.map((field) => {
									return { value: field.name, label: field.label }
								})
							]}
						/>
					{/if}
				</Flex>

				<!-- Layout -->

				<Input type="select" class="w-32"
					bind:value={layout}
					options={[
						{ icon: "Graph",    label: "Graph",  value: "graph" },
						{ icon: "GridFour", label: "Grid",   value: "grid"  },
						{ icon: "Table",    label: "Table",  value: "table" }
					]}
				/>
			</Flex>

		</PageHeader>
	{/snippet}

	{#snippet article()}
		<Section gap={6} class="p-12">
			{#if activeProject && characters.length > 0}


				<!-- Graph -->

				{#if layout === 'graph'}
					<p class="font-style-placeholder">This layout type isn't working yet. Try again later.</p>
				

				<!-- Grid -->

				{:else if layout === 'grid'}
					<CharacterGrid
						characters={characterList}
						cols={gridRows}
					/>
				
			
				<!-- Table -->

				{:else if layout === 'table'}
					<CharacterTable
						characters={characterList}
					/>


				{/if}
			{:else}
				<p class="mt-12 font-style-placeholder">There are no characters for this project yet. <Link href={route('characters.create')}>Create one?</Link></p>
			{/if}
		</Section>
	{/snippet}

</AuthenticatedLayout>