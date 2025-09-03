<script>
	import { Link, page, router, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'

	import CharacterGrid 		from '@/Partials/CharacterGrid.svelte'
	import CharacterTable		from '@/Partials/CharacterTable.svelte'

	import ApplyTagsForm		from '@/Forms/Tags/Apply.svelte'
	import CreateCharacterForm 	from '@/Forms/Character/Create.svelte'
	import CreateCollectionForm from '@/Forms/Collection/Create.svelte'
	import DeleteCharacterForm 	from '@/Forms/Character/Delete.svelte'
	import RenameCharacterForm 	from '@/Forms/Character/Rename.svelte'
	
	import { Flex, Grid, Stack } from '@/Components/Core'
	import Dropdown				from '@/Components/UI/Dropdown.svelte'
	import Icon					from '@/Components/UI/Icon.svelte'
	import Input				from '@/Components/UI/Input.svelte'
	import Modal				from '@/Components/UI/Modal.svelte'
	import PageHeader			from '@/Components/UI/PageHeader.svelte'
	import Section				from '@/Components/UI/Section.svelte'

	import CharacterCard 		from '@/Components/Features/Character/CharacterCard.svelte'

	//	Page props
	const activeProject	= $page.props.activeProject.data
	const collections	= $page.props.collections?.data
	const customFields	= $page.props.customFields?.data
	const tags			= $page.props.tags?.data

	const characters    = activeProject?.characters
	const factions      = activeProject?.factions
	const locations     = activeProject?.locations

	//	State
	let selectedCharacter = $state(null)
	let columns   = $state(['name', 'faction', 'relationships', 'location'])
	let filter    = $state('')
	let layout    = $state('grid')
	let query     = $state('')
	let rowSize   = $state(8)
	let sortBy    = $state('name')
	let sortOrder = $state('asc')

	//	State > Modals
	let applyingTags		= $state(false)
	let creatingCharacter	= $state(false)
	let creatingCollection	= $state(false)
	let deletingCharacter	= $state(false)
	let renamingCharacter	= $state(false)

	const applyTags			= (c) => { applyingTags 		= true, selectedCharacter = c; }
	const createCharacter	= (c) => { creatingCharacter 	= true }
	const createCollection	= (c) => { creatingCollection 	= true,	selectedCharacter = c; }
	const deleteCharacter	= (c) => { deletingCharacter 	= true,	selectedCharacter = c; }
	const renameCharacter	= (c) => { renamingCharacter 	= true,	selectedCharacter = c; }
	const closeModal		= ( ) => {  selectedCharacter	= null
										applyingTags 		= false
										creatingCharacter	= false
										creatingCollection	= false
										deletingCharacter	= false
										renamingCharacter	= false
									}

	//	Add Character to Collection
	const addToCollectionForm = useForm({
		'collectionable_id': null,
		'collectionable_type': 'characters'
	})
	const addToCollection = (char, coll) => {

		console.log(char.id, coll.items.map(i => i.collectionable_id))

		$addToCollectionForm.collectionable_id  = char.id
		$addToCollectionForm.patch(
			route('collections.update', { collection: coll.slug }),
			{
				onSuccess: (res) => {
					router.visit(route('characters'), {
						only: ['collections'],
					})
				}
			}
		)
	}

	//	Derived
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
			title="Character List"
			tabs={[
				{ icon: "ListBullets",	label: "List",			active: true },
				{ icon: "SquaresFour",	label: "Collections",	href: route('characters.collections') },
				{ icon: "GearFine",		label: "Settings",		href: route('characters.settings') },
			]}
			actions={[
				{ icon: "Plus",			label: "Create", 		onclick: createCharacter, theme: "accent" },
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

			<Dropdown class="w-48" contentClass="w-48" icon="FunnelSimple" label="All characters" bind:value={filter} options={[
				{ label: 'Nameless',   value: 'noname' },
				{ separator: true },
				{ label: 'In Faction...', children: factions.map(f => {
					return { label: f.name, value: `faction.${f.slug}`, image: f.emblem?.url }
				}) },
				{ label: 'At Location...', children: locations.map(l => {
					return { label: l.name, value: `location.${l.slug}`, image: l.banner?.url }
				}) },
				{ label: 'With Relationships...', children: characters.map(c => {
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

			<!-- Layout -->

			<Input type="select" class="w-36"
				bind:value={layout}
				options={[
					{ icon: "Graph",    label: "As Graph",  value: "graph" },
					{ icon: "GridFour", label: "As Grid",   value: "grid"  },
					{ icon: "Table",    label: "As Table",  value: "table" }
				]}
			/>

			<!-- Layout-specific Controls -->

			<Flex gap={1.5} class="min-w-40 flex-shrink-0">
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

			<!-- Result Count -->

			<div class="bg-emerald-500/10 text-emerald-500 whitespace-nowrap rounded-lg px-3 p-2">{characterList.length} {characterList.length !== 1 ? 'results' : 'result'}</div>

			
		</Flex>

		<Section gap={6} class="p-12 pt-20">
			{#if activeProject && characters.length > 0}


				<!-- Graph -->

				{#if layout === 'graph'}
					<p class="font-style-placeholder">This layout type isn't working yet. Try again later.</p>
				

				<!-- Grid -->

				{:else if layout === 'grid'}
					<CharacterGrid
						characters={characterList}
						cols={gridRows}
					>
						{#snippet gridItem(character)}
							<CharacterCard
								character={character}
								options={[
									{ label: "View",   icon: "Eye", href: route('characters.show', {character: character.slug}) },
									{ label: "Rename", icon: "Textbox", onclick: () => renameCharacter(character) },
									{ separator: true },
									{ label: "Add to Collection",	icon: "FolderSimple",
										options: [
											...collections.map(c => {
												return {
													label: c.name,
													icon: "FolderSimple",
													onclick: () => addToCollection(character, c),
													disabled: c.items.map(i => i.collectionable_id).includes(character.id),
													iconWeight: c.items.map(i => i.collectionable_id).includes(character.id) ? 'fill' : 'light' }
											}),
											{ label: "New Collection", icon: "Plus", onclick: () => createCollection(character), theme: "accent" }
										]
									},
									{ label: "Add Tags", icon: "TagSimple", onclick: () => applyTags(character) },
									{ label: "Set Faction", icon: "FlagBannerFold" },
									{ label: "Set Location", icon: "MapPinArea" },
									{ separator: true },
									{ label: "Delete Character", icon: "Trash",		onclick: () => deleteCharacter(character), theme: "danger" }
								]}
							/>
						{/snippet}
					</CharacterGrid>
				
			
				<!-- Table -->

				{:else if layout === 'table'}
					<CharacterTable
						characters={characterList}
					/>


				{/if}
			{:else}
				<p class="mt-12 font-style-placeholder">There are no characters for this project yet. <Link>Create one?</Link></p>
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
	<ApplyTagsForm type="characters" entity={selectedCharacter || null} oncancel={closeModal} />
</Modal>

<Modal
	title="Create a new character"
	maxWidth="lg"
	show={creatingCharacter}
	onclose={closeModal}
>
	<CreateCharacterForm oncancel={closeModal} />
</Modal>

<Modal
	title="Rename {selectedCharacter?.name}?"
	maxWidth="lg"
	show={renamingCharacter}
	onclose={closeModal}
>
	<RenameCharacterForm character={selectedCharacter || null} oncancel={closeModal} />
</Modal>

<Modal
	title="Delete {selectedCharacter?.name}?"
	maxWidth="lg"
	show={deletingCharacter}
	onclose={closeModal}
>
	<DeleteCharacterForm character={selectedCharacter || null} oncancel={closeModal} />
</Modal>

<Modal
	title="Create Collection"
	maxWidth="lg"
	show={creatingCollection}
	onclose={closeModal}
>
	<CreateCollectionForm type="characters" entity={selectedCharacter || null} oncancel={closeModal} />
</Modal>