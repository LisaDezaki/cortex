<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	
	import Empty				from '@/Components/UI/Empty.svelte'
	import PageHeader			from '@/Components/UI/PageHeader.svelte'
	import Section				from '@/Components/UI/Section.svelte'
	import CharacterCard		from '@/Components/Features/Character/CharacterCard.svelte'
	import CharacterControlBar 	from '@/Components/Features/Character/CharacterControlBar.svelte'
	import CharacterGrid 		from '@/Components/Features/Character/CharacterGrid.svelte'
	import CharacterTable		from '@/Components/Features/Character/CharacterTable.svelte'


	//	Page props

	const activeProject		= $page.props.activeProject.data
	const collections		= $page.props.collections?.data
	const characters    	= activeProject?.characters
	const factions    		= activeProject?.factions
	const locations    		= activeProject?.locations


	//	State & Derived values

	let filteredCharacters  = $state(characters)
	let selectedCharacter 	= $state(null)
	let layout    			= $state('grid')
	let rowSize   			= $state(8)
	let gridCols 			= $derived(16-rowSize)


	//	Modal Management

	import { modalActions } from '@/stores/modalStore';

	function createCharacter() 		{ modalActions.open('createCharacter') 	}
	function createFaction()		{ modalActions.open('createFaction') 	}
	function createLocation()		{ modalActions.open('createLocation') 	}
	function createCollection()		{ modalActions.open('createCollection') }
    function deleteCharacter(char) 	{ modalActions.open('deleteCharacter', 	{ character: char 	}) }
	function renameCharacter(char) 	{ modalActions.open('renameCharacter', 	{ character: char 	}) }
	function setFaction(char)		{ modalActions.open('setCharacterFaction')  }
	function setLocation(char)		{ modalActions.open('setCharacterLocation') }

	// const createFaction		= ( ) 	 => { /* TODO */ }
	// const setFaction		= (c, f) => { /* TODO */ }
	const removeFaction		= (c) 	 => { /* TODO */ }

	// const createLocation	= ( ) 	 => { /* TODO */ }
	// const setLocation		= (c, l) => { /* TODO */ }
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