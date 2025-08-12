<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionGrid from '@/Partials/FactionGrid.svelte'
	import FactionTable from '@/Partials/FactionTable.svelte'

	import { Flex, Inline } from '@/Components/Core'

	import Back         from '@/Components/UI/Back.svelte'
	import Dropdown     from '@/Components/UI/Dropdown.svelte'
	import Heading      from '@/Components/UI/Heading.svelte'
	import Icon         from '@/Components/UI/Icon.svelte'
	import Input        from '@/Components/UI/Input.svelte'
	import Section      from '@/Components/UI/Section.svelte'

	const activeProject = $page.props.activeProject.data
	const customFields  = $page.props.customFields?.data
	const characters    = activeProject?.characters
	const factions      = activeProject?.factions
	const locations     = activeProject?.locations

	let columns   = $state(['name', 'members', 'headquarters'])
	let filter    = $state({})
	let layout    = $state('grid')
	let query     = $state('')
	let rowSize   = $state(8)
	let sortBy    = $state('name')
	let sortOrder = $state('asc')

	let filteredFactions = $state(factions)
	let selectedFactions = $state([])

	let gridRows    = $derived( 16-rowSize )
	let hasFilter   = $derived( Boolean(filter.name && filter.value) )
	let factionList = $derived(
		factions
			.filter(c => {
				if (query.length > 0 && !c.name.toLowerCase().includes(query.toLowerCase())) { return false }
				// if (hasFilter && filter.name === 'Faction' && c.factions[0]?.name !== filter.value) { return false }
				return true
			}).sort((a, b) => {
				if (sortBy === 'name') { return a.name > b.name ? 1 : -1 }
			})
	)

	let factionListSorted = $derived( sortOrder == 'asc' ? factionList : factionList.reverse())

	// function filterFactions(e) {
	// 	filteredFactions = query.length == 0
	// 		? factions
	// 		: factions.filter(c => {
	// 			let string = `${c.name} ${c.alias}`;
	// 			return string.toLowerCase().includes(e.target.value.toLowerCase());
	// 		})
	// }

</script>

<svelte:head>
    <title>{activeProject?.name} Factions</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet article()}
		<Back href="/" />
		<Section class="space-y-6">
			<Heading is="h2" as="h4"
				heading="Factions"
				actions={[
					{ icon: "Plus",     theme: "accent",  href: route('factions.create'),   label: "Create" },
					{ icon: "GearFine", theme: "neutral", href: route('factions.settings'), },
				]}
			/>
			<Flex align="start" gap={3}>

				<!-- Search -->

				<Input type="search" bind:value={query} class="max-w-48"
					icon="MagnifyingGlass" name="search" placeholder="Search..."
				/>

				<!-- Filter -->

				<Dropdown class="w-48" contentClass="w-48" icon="FunnelSimple" label="All characters" bind:value={filter} options={[
					{ label: 'Nameless',   value: 'noname' },
					{ label: 'Incomplete', value: 'incomplete' },
					{ separator: true },
					{ label: 'Characters...', children: characters.map(c => {
						return { label: c.name, value: `character.${c.slug}`, image: c.portrait?.url }
					}) },
					{ label: 'Headquarters...', children: locations.map(l => {
						return { label: l.name, value: `location.${l.slug}`, image: l.banner?.url }
					}) },
					...customFields.filter(f => f.type == 'select').map(f => {
						return { label: `${f.label}...`, children: f.options.map(o => {
							return { label: o.label, value: `${f.name}.${o.value}` }
						})}
					})
				]} />

				<!-- Sort -->

				<Input type="select" class="w-48" icon="SortAscending" placeholder="Sort by" bind:value={sortBy} options={[
					{ value: 'name',         label: "By name" },
					{ value: 'members',      label: "By member count" },
					{ separator: true },
					{ value: 'created-at',   label: "Date Created" },
					{ value: 'updated-at',   label: "Date Updated" },
					{ value: 'random',       label: "Randomly" },
				]} />

				<!-- Result Count -->

				<div class="bg-emerald-500/10 text-emerald-500 rounded-lg p-2">{factionList.length} {factionList.length !== 1 ? 'results' : 'result'}</div>

				<!-- Size-->

				<Inline gap={1.5} class="ml-auto min-w-40 flex-shrink-0">
					{#if layout === 'grid'}
						<Icon name="Resize" size="md" />
						<Input type="slider" style="none" class="" showValue={false} min={4} max={12} bind:value={rowSize} />
					{:else if layout === 'table'}
						<Input type="select" class="ml-auto" multiple overrideLabel="Columns" bind:value={columns} options={[
							{ value: 'name',         label: "Name" },
							{ value: 'members',      label: "Members" },
							{ value: 'headquarters', label: "Headquarters" },
							// ...customFields.map((field) => {
							// 	return { value: field.name, label: field.label }
							// })
						]} />
					{/if}
				</Inline>

				<!-- Layout -->

				<Input type="select" class="w-32"
					bind:value={layout}
					options={[
						{ icon: "GridFour", label: "Grid",   value: "grid"  },
						{ icon: "Table",    label: "Table",  value: "table" }
					]}
				/>

				<!-- <SetLayout bind:layout options={[
					{ icon: "GridFour", value: "grid"  },
					{ icon: "Table",    value: "table" }
				]} /> -->

			</Flex>

			{#if activeProject && factions?.length > 0}
				{#if layout == 'grid'}
					<FactionGrid factions={factionList} cols={gridRows} showItemControls />
				{:else if layout == 'table'}
					<FactionTable factions={factionList} />
				{/if}
			{:else}
				<p class="mt-12">There are no factions for this project yet. <Link href={route('factions.create')}>Create one?</Link></p>
			{/if}
		</Section>
	{/snippet}
    
</AuthenticatedLayout>