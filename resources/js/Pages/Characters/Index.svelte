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
	import Modal		from '@/Components/UI/Modal.svelte'
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
	const deleteCharacter	= (c) => { 	deletingCharacter 	= true,	selectedCharacter = c; }
	const renameCharacter	= (c) => { 	renamingCharacter 	= true,	selectedCharacter = c; }
	const createCollection	= (c) => { 	creatingCollection 	= true,	selectedCharacter = c; }
	const applyTags			= (c) => { 	applyingTags 		= true, selectedCharacter = c; }
	const closeModal		= ( ) => {  selectedCharacter	= null
										creatingCharacter	= false
										deletingCharacter	= false
										renamingCharacter	= false
										creatingCollection	= false
										applyingTags 		= false
																	}

	//	Add Character to Collection
	const addToCollectionForm = useForm({
		items: [{ id: null, type: 'characters' }]
	})

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
				{ label: "List",			active: true },
				{ label: "Collections",	href: route('characters.collections') },
				{ label: "Settings",		href: route('characters.settings') },
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



<Modal title="Create a new character" show={creatingCharacter} maxWidth="lg"
	onclose={closeModal}>
	<CreateCharacterForm
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>

<Modal title="Rename {selectedCharacter?.name}?" show={renamingCharacter} maxWidth="lg"
	onclose={closeModal}>
	<RenameCharacterForm character={selectedCharacter || null}
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>

<Modal title="Delete {selectedCharacter?.name}?" show={deletingCharacter} maxWidth="lg"
	onclose={closeModal}>
	<DeleteCharacterForm character={selectedCharacter || null}
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>

<Modal title="Create Collection" show={creatingCollection} maxWidth="lg"
	onclose={closeModal}>
	<CreateCollectionForm type="characters" entity={selectedCharacter || null}
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>

<Modal title="Apply Tags" show={applyingTags} maxWidth="lg"
	onclose={closeModal}>
	<ApplyTagsForm type="characters" entity={selectedCharacter || null}
		onSuccess={closeModal} oncancel={closeModal} />
</Modal>