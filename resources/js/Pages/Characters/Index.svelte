<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'

	import CreateCharacterForm 	from '@/Forms/Character/Create.svelte'
	import DeleteCharacterForm 	from '@/Forms/Character/Delete.svelte'
	import RenameCharacterForm 	from '@/Forms/Character/Rename.svelte'
	import CreateCollectionForm from '@/Forms/Collection/Create.svelte'
	import ApplyTagsForm		from '@/Forms/Tags/Apply.svelte'
	
	import Empty		from '@/Components/UI/Empty.svelte'
	import PageHeader	from '@/Components/UI/PageHeader.svelte'
	import Section		from '@/Components/UI/Section.svelte'
	
	import CharacterCard	from '@/Components/Features/Character/CharacterCard.svelte'
	import CharacterControlBar from '@/Components/Features/Character/CharacterControlBar.svelte'
	import CharacterGrid 	from '@/Components/Features/Character/CharacterGrid.svelte'
	import CharacterTable	from '@/Components/Features/Character/CharacterTable.svelte'

	//	Page props
	const activeProject		= $page.props.activeProject.data
	const collections		= $page.props.collections?.data
	const characters    	= activeProject?.characters
	const factions    		= activeProject?.factions
	const locations    		= activeProject?.locations

	//	State
	let filteredCharacters  = $state(characters)
	let selectedCharacter 	= $state(null)
	let layout    			= $state('grid')
	let rowSize   			= $state(8)

	let gridCols 			= $derived(16-rowSize)

	//	State > Modals
	let creatingCharacter	= $state(false)
	let deletingCharacter	= $state(false)
	let renamingCharacter	= $state(false)
	let creatingCollection	= $state(false)
	let applyingTags		= $state(false)

	const createCharacter	= ( ) => { 	creatingCharacter 	= true }
	const deleteCharacter	= (c) => { 	selectedCharacter = c; deletingCharacter 	= true; }
	const renameCharacter	= (c) => { 	selectedCharacter = c; renamingCharacter 	= true; }
	const createCollection	= (c) => { 	selectedCharacter = c; creatingCollection 	= true; }
	const applyTags			= (c) => { 	selectedCharacter = c; applyingTags 		= true; }
	const closeModal		= ( ) => {  creatingCharacter	= false
										deletingCharacter	= false
										renamingCharacter	= false
										creatingCollection	= false
										applyingTags 		= false
										setTimeout(() => selectedCharacter = null, 300)
									 }

	const createFaction		= ( ) 	 => { /* TODO */ }
	const setFaction		= (c, f) => { /* TODO */ }
	const removeFaction		= (c) 	 => { /* TODO */ }

	const createLocation	= ( ) 	 => { /* TODO */ }
	const setLocation		= (c, l) => { /* TODO */ }
	const removeLocation	= (c) 	 => { /* TODO */ }

	//	Add Character to Collection
	// const renameCharacterForm = useForm({
	// 	name: ''
	// })
	const addToCollectionForm = useForm({
		items: [{ id: null, type: 'characters' }]
	})

	let selectedCharacterName = $derived(selectedCharacter?.name ||'')

	function addToCollection(char, coll) {
		$addToCollectionForm.items[0]  = { id: char.id, type: 'characters' }
		$addToCollectionForm.patch(
			route('collections.update', { collection: coll.slug })
		)
	}

	// function updateControls(filteredList, controls) {
	// 	characterList = filteredList
	// 	layout = controls.layout
	// }

</script>

<svelte:head>
    <title>Character List</title>
</svelte:head>





<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			title="Character List"
			tabs={[
				{ label: "List",		active: true },
				{ label: "Collections",	href: route('characters.collections') },
				{ label: "Settings",	href: route('characters.settings') },
			]}
			actions={[
				{ icon: "Plus",			label: "Create Character", onclick: createCharacter, theme: "accent" },
			]}
		/>
	{/snippet}

	{#snippet article()}

		{#if activeProject}
			<CharacterControlBar
				data={characters}
				bind:filteredData={filteredCharacters}
				project={activeProject}
			/>
		{/if}

		<Section gap={6} class="px-12 py-6">
			{#if activeProject && characters.length > 0}


				<!-- Grid -->

				{#if layout === 'grid'}
					<CharacterGrid
						characters={filteredCharacters}
						cols={gridCols}
					>
						{#snippet gridItem(character)}
							<CharacterCard
								character={character}
								iconOptions={[
									{ icon: "Eye", 		href: route('characters.show', {character: character.slug}) },
									{ icon: "Textbox", 	onclick: () => renameCharacter(character) },
									{ icon: "Star", 	onclick: () => renameCharacter(character) },
									{ icon: "Trash", 	onclick: () => deleteCharacter(character), theme: "danger" },
								]}
								options={[{
									label: "Add to Collection",
									create: () => createCollection(character),
									options: [ ...collections.map(c => ({
										label: c.name,
										onclick: () => addToCollection(character, c),
										disabled: c.items.map(i => i.collectionable_id).includes(character.id),
										iconWeight: c.items.map(i => i.collectionable_id).includes(character.id) ? 'fill' : 'light'
									}))]
								},{
									label: "Add Tags",
									onclick: () => applyTags(character)
								},{
									label: "Remove Faction",
									hideIf: character.factions.length == 0,
									onclick: () => removeFaction(character)
								},{
									label: "Set Faction",
									hideIf: character.factions.length  > 0,
									create: () => createFaction(),
									options: [ ...factions.map(f => ({
										label: f.name,
										onclick: () => setFaction(character, f)
									})) ]
								},{
									label: "Remove Location",
									hideIf: character.location == null,
									onclick: () => removeLocation(character)
								},{
									label: "Set Location",
									hideIf: character.location != null,
									create: () => createLocation(),
									options: [ ...locations.map(l => ({
										label: l.name,
										onclick: () => setLocation(character, l)
									}))]
								},{
									separator: true
								},{
									label: "Delete Character",
									onclick: () => deleteCharacter(character),
									theme: "danger"
								}
								]}
							/>
						{/snippet}
					</CharacterGrid>
				
			
				<!-- Table -->

				{:else if layout === 'table'}
					<CharacterTable
						characters={filteredCharacters}
					/>

				<!-- Graph -->

				{:else if layout === 'graph'}
					<Empty
						icon="Graph"
						message="This layout type isn't working yet. Try again later."
					/>

				{/if}
			{:else}

				<Empty
					icon="User"
					message="There are no characters for this project yet."
					buttonLabel="Create one?"
					buttonClick={createCharacter}
				/>

			{/if}
		</Section>

		
	{/snippet}

</AuthenticatedLayout>





<CreateCharacterForm isOpen={creatingCharacter}
	onSuccess={closeModal} oncancel={closeModal}
/>
<RenameCharacterForm isOpen={renamingCharacter} character={selectedCharacter}
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['characters']}
/>
<DeleteCharacterForm isOpen={deletingCharacter} character={selectedCharacter}
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['characters']}
/>
<CreateCollectionForm isOpen={creatingCollection} entity={selectedCharacter} type="characters"
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['characters.collections', 'collections']}
/>
<ApplyTagsForm isOpen={applyingTags} entity={selectedCharacter} type="characters"
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['characters.tags', 'tags']}
/>