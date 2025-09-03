<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import FactionGrid from '@/Partials/FactionGrid.svelte'
	import FactionTable from '@/Partials/FactionTable.svelte'

	import ApplyTagsForm		from '@/Forms/Tags/Apply.svelte'
	import CreateCollectionForm from '@/Forms/Collection/Create.svelte'
	import CreateFactionForm 	from '@/Forms/Faction/Create.svelte'
	import DeleteFactionForm 	from '@/Forms/Faction/Delete.svelte'
	import RenameFactionForm 	from '@/Forms/Faction/Rename.svelte'

	import { Flex, Inline, Stack } from '@/Components/Core'
	import Dropdown     from '@/Components/UI/Dropdown.svelte'
	import Icon         from '@/Components/UI/Icon.svelte'
	import Input        from '@/Components/UI/Input.svelte'
	import Modal		from '@/Components/UI/Modal.svelte'
	import PageHeader	from '@/Components/UI/PageHeader.svelte'
	import Section      from '@/Components/UI/Section.svelte'

	import FactionCard 		from '@/Components/Features/Faction/FactionCard.svelte'

	//	Page props
	const activeProject = $page.props.activeProject.data
	const collections	= $page.props.collections?.data
	const customFields  = $page.props.customFields?.data
	const tags			= $page.props.tags?.data

	const characters    = activeProject?.characters
	const factions      = activeProject?.factions
	const locations     = activeProject?.locations

	//	State
	let selectedFaction = $state(null)
	let columns   = $state(['name', 'members', 'headquarters'])
	let filter    = $state({})
	let layout    = $state('grid')
	let query     = $state('')
	let rowSize   = $state(8)
	let sortBy    = $state('name')
	let sortOrder = $state('asc')

	//	State > Modals
	let applyingTags		= $state(false)
	let creatingFaction	= $state(false)
	let creatingCollection	= $state(false)
	let deletingFaction	= $state(false)
	let renamingFaction	= $state(false)

	const applyTags			= (f) => { applyingTags = true,			selectedFaction = f; }
	const createFaction		= ( ) => { creatingFaction 	= true }
	const createCollection	= (f) => { creatingCollection = true,	selectedFaction = f; }
	const deleteFaction		= (f) => { deletingFaction = true,		selectedFaction = f; }
	const renameFaction		= (f) => { renamingFaction = true,		selectedFaction = f; }
	const closeModal		= ( ) => {  selectedFaction	= null
										applyingTags = false
										creatingFaction	= false
										creatingCollection = false
										deletingFaction	= false
										renamingFaction	= false
									}



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
    <title>Faction List</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			title="Faction List"
			tabs={[
				{ icon: "ListBullets",	label: "List",			active: true },
				{ icon: "SquaresFour",	label: "Collections",	href: route('factions.collections') },
				{ icon: "GearFine",		label: "Settings",		href: route('factions.settings') },
			]}
			actions={[
				{ icon: "Plus",			label: "Create", 		onclick: createFaction, theme: "accent" },
			]}
		/>
	{/snippet}
	
	{#snippet article()}

		<Flex align="start" gap={3}
			class="backdrop-blur-lg bg-white/50 border-b border-neutral-softest absolute top-0 left-0 px-12 py-3 w-full z-50"
		>

			<!-- Search -->

			<Input type="search" bind:value={query} class="w-48"
				icon="MagnifyingGlass" name="search" placeholder="Search..."
			/>

			<!-- Filter -->

			<Dropdown class="w-48" contentClass="w-48" icon="FunnelSimple" label="All factions" bind:value={filter} options={[
				{ label: 'Nameless',   value: 'noname' },
				{ label: 'Incomplete', value: 'incomplete' },
				{ separator: true },
				{ label: 'Headquarters at...', children: locations.map(l => {
					return { label: l.name, value: `location.${l.slug}`, image: l.banner?.url }
				}) },
				{ label: 'Has member...', children: characters.map(c => {
					return { label: c.name, value: `character.${c.slug}`, image: c.portrait?.url }
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

			<!-- Layout -->

			<Input type="select" class="w-36"
				bind:value={layout}
				options={[
					{ icon: "GridFour", label: "Grid",   value: "grid"  },
					{ icon: "Table",    label: "Table",  value: "table" }
				]}
			/>

			<!-- Size-->

			<Inline gap={1.5} class="min-w-40 flex-shrink-0">
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

			<!-- Result Count -->

			<div class="bg-emerald-500/10 text-emerald-500 rounded-lg p-2">{factionList.length} {factionList.length !== 1 ? 'results' : 'result'}</div>

		</Flex>

		<Section gap={6} class="p-12 pt-20">
			{#if activeProject && factions?.length > 0}


				<!-- Grid -->

				{#if layout == 'grid'}
					<FactionGrid
						factions={factionList}
						cols={gridRows}
					>
						{#snippet gridItem(faction)}
							<FactionCard
								faction={faction}
								options={[
									{ label: "View",   icon: "Eye", href: route('factions.show', {faction: faction.slug}) },
									{ label: "Rename", icon: "Textbox", onclick: () => renameFaction(faction) },
									{ separator: true },
									{ label: "Add to Collection",	icon: "FolderSimple",
										options: [
											...collections.map(c => {
												return { label: c.name, icon: "FolderSimple", onclick: () => addToCollection(faction, c) }
											}),
											{ label: "New Collection", icon: "Plus", onclick: () => createCollection(faction), theme: "accent" }
										]
									},
									{ label: "Add Tags", icon: "TagSimple", onclick: () => applyTags(faction) },
									{ label: "Add Character", icon: "UsersThree" },
									{ label: "Set Location", icon: "MapPinArea" },
									{ separator: true },
									{ label: "Delete Faction", icon: "Trash",		onclick: () => deleteFaction(faction), theme: "danger" }
								]}
							/>
						{/snippet}
					</FactionGrid>
				

				<!-- Table -->

				{:else if layout == 'table'}
					<FactionTable
						factions={factionList}
					/>


				{/if}
			{:else}
				<p class="mt-12 font-style-placeholder">There are no factions for this project yet. <Link href={route('factions.create')}>Create one?</Link></p>
			{/if}
		</Section>
	{/snippet}
    
</AuthenticatedLayout>

<Modal
	title="Apply Tags"
	maxWidth="lg"
	show={applyingTags}
	onclose={closeModal}
>
	<ApplyTagsForm type="characters" entity={selectedFaction || null} oncancel={closeModal} />
</Modal>

<Modal
	title="Create a new character"
	maxWidth="lg"
	show={creatingFaction}
	onclose={closeModal}
>
	<CreateFactionForm oncancel={closeModal} />
</Modal>

<Modal
	title="Rename {selectedFaction?.name}?"
	maxWidth="lg"
	show={renamingFaction}
	onclose={closeModal}
>
	<RenameFactionForm faction={selectedFaction || null} oncancel={closeModal} />
</Modal>

<Modal
	title="Delete {selectedFaction?.name}?"
	maxWidth="lg"
	show={deletingFaction}
	onclose={closeModal}
>
	<DeleteFactionForm faction={selectedFaction || null} oncancel={closeModal} />
</Modal>

<Modal
	title="Create Collection"
	maxWidth="lg"
	show={creatingCollection}
	onclose={closeModal}
>
	<CreateCollectionForm type="characters" entity={selectedFaction || null} oncancel={closeModal} />
</Modal>