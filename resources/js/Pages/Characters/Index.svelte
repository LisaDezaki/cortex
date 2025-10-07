<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import Empty				from '@/Components/UI/Empty.svelte'
	import PageHeader			from '@/Components/UI/PageHeader.svelte'
	import Section				from '@/Components/UI/Section.svelte'
	import CharacterCard		from '@/Components/Features/Character/CharacterCard.svelte'
	import CharacterControlBar 	from '@/Components/Features/Character/CharacterControlBar.svelte'
	import CharacterGrid 		from '@/Components/Features/Character/CharacterGrid.svelte'
	import CharacterTable		from '@/Components/Features/Character/CharacterTable.svelte'


	//	Page props

	import ProjectObject 	from '@/services/ProjectObject'
	import CollectionList 	from '@/services/CollectionList'
	const activeProject	  = $state(new ProjectObject($page.props.activeProject.data))
	const collections	  = $state(new CollectionList($page.props.collections?.data))
	const characters      = $state(activeProject?.characters)
	const factions    	  = $state(activeProject?.factions)
	const locations    	  = $state(activeProject?.locations)


	//	State & Derived values

	let query	 = $state('')
	let filter	 = $state('')
	let sort	 = $state('name')
	let size	 = $state(8)
	let layout	 = $state('grid')
	let gridCols = $derived(16-size)
	let results  = $derived(characters.items)

	function getSubtitle(character) {
		switch (sort) {
			case 'popularity':
				return character.relationships?.items?.length + ' Relationships'
			case 'location':
				return character.location?.name || '--'
			case 'faction':
				return character.factions?.items?.[0]?.name || '--'
			case 'created_at':
				return new Date(character.meta?.createdAt).toLocaleString() || '--'
			case 'updated_at':
				return new Date(character.meta?.updatedAt).toLocaleString() || '--'
			default:
				return character.alias
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
				{ label: "List",		active: true },
				{ label: "Collections",	href: route('characters.collections') },
				{ label: "Settings",	href: route('characters.settings') },
			]}
			actions={[
				{ icon: "Plus", label: "Create Character", theme: "accent", onclick: () => characters.create() },
			]}
		/>
	{/snippet}

	{#snippet article()}

		{#if activeProject}
			<CharacterControlBar
				data={characters} project={activeProject}
				bind:query bind:filter bind:sort
				bind:results bind:size bind:layout
			/>
		{/if}

		<Section gap={6} class="px-20 py-6">
			{#if activeProject && results.length > 0}


				<!-- Grid -->

				{#if layout === 'grid'}
					<CharacterGrid
						characters={results}
						cols={gridCols}
					>
						{#snippet gridItem(character)}
							<CharacterCard starrable
								character={character}
								subtitle={getSubtitle(character)}
								href={character.routes?.show}
								iconOptions={[
									{ icon: "Star", 		onclick: () => character.star(), iconWeight: character.starred ? 'fill' : 'regular' },
									{ icon: "Eye", 			href: character.routes?.show },
									{ icon: "Textbox", 		onclick: () => character.rename() },
									{ icon: "UploadSimple", onclick: () => character.addPortrait() },
									{ icon: "Trash", 		onclick: () => character.delete(), theme: "danger" },
								]}
								options={[{
									icon: 'FlagBannerFold', iconWeight: 'regular',
									label: "Factions...",
									create: () => factions.create(),
									options: [ ...factions.items.map(f => ({
										...f,
										active: f.id === character.factions?.items?.[0]?.id,
										label: f.name,
										onclick: () => character.setFaction(f)
									})) ]
								},{
									icon: 'MapPin', iconWeight: 'regular',
									label: "Location...",
									create: () => locations.create(),
									options: [ ...locations.items.map(l => ({
										...l,
										active: l.id === character.location?.id,
										label: l.name,
										onclick: () => character.setLocation(l)
									}))]
								},{
									separator: true
								},{
									icon: 'FolderSimple', iconWeight: 'regular',
									label: "Add to Collection",
									create: () => collections.create('characters', [character]),
									options: [ ...collections.items.map(collection => ({
										label: collection.name,
										onclick: 	collection.items.map(i => i.collectionable_id).includes(character.id) ? () => collection.removeItem(character) : () => collection.addItem(character),
										disabled:   collection.items.map(i => i.collectionable_id).includes(character.id),
										iconWeight: collection.items.map(i => i.collectionable_id).includes(character.id) ? 'fill' : 'light'
									}))]
								},{
									icon: 'TagSimple', iconWeight: 'regular',
									label: "Add Tags",
									onclick: () => character.addTags()
								},{
									separator: true
								},{
									icon: 'Trash', iconWeight: 'regular',
									label: "Delete Character",
									onclick: () => character.delete(),
									theme: "danger"
								}]}
							/>
						{/snippet}
					</CharacterGrid>
				
			
				<!-- Table -->

				{:else if layout === 'table'}
					<CharacterTable
						characters={results}
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
					buttonClick={() => characters.create()}
				/>

			{/if}
		</Section>

		
	{/snippet}

</AuthenticatedLayout>