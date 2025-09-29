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
	import CharacterList 	from '@/services/CharacterList'
	import FactionList 		from '@/services/FactionList'
	import LocationList 	from '@/services/LocationList'
	const activeProject	  = $state(new ProjectObject($page.props.activeProject.data))
	const collections	  = $state(new CollectionList($page.props.collections?.data))
	const characters      = $state(new CharacterList(activeProject?.characters))
	const factions    	  = $state(new FactionList(activeProject?.factions))
	const locations    	  = $state(new LocationList(activeProject?.locations))


	//	State & Derived values

	let query	 = $state('')
	let filter	 = $state('')
	let sort	 = $state('name')
	let size	 = $state(8)
	let layout	 = $state('table')
	let gridCols = $derived(16-size)

	let results = $derived(characters.items)

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

		<Section gap={6} class="px-12 py-6">
			{#if activeProject && results.length > 0}


				<!-- Grid -->

				{#if layout === 'grid'}
					<CharacterGrid
						characters={results}
						cols={gridCols}
					>
						{#snippet gridItem(character)}
							<CharacterCard
								character={character}
								href={character.routes.show}
								iconOptions={[
									{ icon: "Star", 	onclick: () => character.star(), iconWeight: character.starred ? 'fill' : 'regular' },
									{ icon: "Eye", 		href: character.routes.show },
									{ icon: "Textbox", 	onclick: () => character.rename() },
									{ icon: "Trash", 	onclick: () => character.delete(), theme: "danger" },
								]}
								options={[{
									label: "Add to Collection",
									create: () => collections.create('characters', [character]),
									options: [ ...collections.items.map(collection => ({
										label: collection.name,
										onclick: 	collection.items.map(i => i.collectionable_id).includes(character.id) ? () => collection.removeItem(character) : () => collection.addItem(character),
										disabled:   collection.items.map(i => i.collectionable_id).includes(character.id),
										iconWeight: collection.items.map(i => i.collectionable_id).includes(character.id) ? 'fill' : 'light'
									}))]
								},{
									label: "Add Tags",
									onclick: () => character.addTags()
								},{
									label: "Remove Faction",
									hideIf: character.factions.length == 0,
									onclick: () => character.removeFaction()
								},{
									label: "Set Faction",
									hideIf: character.factions.length  > 0,
									create: () => factions.create(),
									options: [ ...factions.items.map(f => ({
										label: f.name,
										onclick: () => character.setFaction(f)
									})) ]
								},{
									label: character.location?.name,
									hideIf: character.location == null,
									onclick: () => character.removeLocation()
								},{
									label: "Set Location",
									hideIf: character.location != null,
									create: () => locations.create(),
									options: [ ...locations.items.map(l => ({
										label: l.name,
										onclick: () => character.setLocation(l)
									}))]
								},{
									separator: true
								},{
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