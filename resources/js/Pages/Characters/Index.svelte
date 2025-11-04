<script>
	import { onMount } from 'svelte';
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import Box					from '@/Components/Core/Box.svelte'
	import Flex					from '@/Components/Core/Flex.svelte'
	import Grid					from '@/Components/Core/Grid.svelte'
	import Empty				from '@/Components/UI/Empty.svelte'
	import PageHeader			from '@/Components/UI/PageHeader.svelte'
	import Section				from '@/Components/UI/Section.svelte'
	import CharacterCard		from '@/Components/Features/Character/CharacterCard.svelte'
	import CharacterControlBar 	from '@/Components/Features/Character/CharacterControlBar.svelte'
	import CharacterGrid 		from '@/Components/Features/Character/CharacterGrid.svelte'
	import CharacterPanel 		from '@/Components/Features/Character/CharacterPanel.svelte'
	import CharacterTable		from '@/Components/Features/Character/CharacterTable.svelte'


	//	Page props

	import ProjectObject 	from '@/services/ProjectObject'
	import CollectionList 	from '@/services/CollectionList'
	const activeProject	  = $state(new ProjectObject($page.props.activeProject.data))
	const collections	  = $state(new CollectionList($page.props.collections?.data))
	const characters      = $state(activeProject?.characters)
	const factions    	  = $state(activeProject?.factions)
	const locations    	  = $state(activeProject?.locations)

	let urlParams = new URLSearchParams(typeof window !== 'undefined' ? window.location.search : '');


	//	Reactive State

	let parameters = $state({
		query: 		urlParams.get('q')		|| '',
		filter: 	urlParams.get('filter') || '',
		sort: 		urlParams.get('sort')	|| 'name',
		direction: 	urlParams.get('dir')	|| 'desc',
		size: 		urlParams.get('size')	|| 6,
		layout: 	urlParams.get('layout')	|| 'grid',
		selected: 	urlParams.get('selected') || ''
	})

	let gridCols = $derived(12-parameters.size)
	let results  = $derived(characters.items)


	/**
	 * Sync with URL
	 * Update filters from URL on Mount
	 */
	onMount(() => {
		urlParams = new URLSearchParams(window.location.search);
		parameters = {
			query: 		urlParams.get('q') 		|| '',
			filter: 	urlParams.get('filter') || '',
			sort: 		urlParams.get('sort') 	|| 'name',
			direction: 	urlParams.get('dir') 	|| 'desc',
			size: 		urlParams.get('size') 	|| 6,
			layout: 	urlParams.get('layout') || 'grid',
			selected: 	urlParams.get('selected') || ''
		};
	});

	/**
	 * Update URL
	 * Update URL params (without page reload) when filters change
	 */
	$effect(() => {
		const url = new URL(window.location);
		if (parameters.query)	{ url.searchParams.set('q', parameters.query); }
		else 					{ url.searchParams.delete('q'); }
		if (parameters.filter)	{ url.searchParams.set('filter', parameters.filter); }
		else					{ url.searchParams.delete('filter'); }
		url.searchParams.set('size',		parameters.size);
		url.searchParams.set('sort',		parameters.sort);
		url.searchParams.set('direction',	parameters.direction);
		url.searchParams.set('layout',		parameters.layout);
		url.searchParams.set('selected',	parameters.selected);
		window.history.replaceState({}, '', url);
	});


	/**
	 * Get Subtitle
	 * @param character A CharacterObject class instance
	 * @return {string} Subtitle to display on Character Cards
	 */
	function getSubtitle(character) {
		switch (parameters.sort) {
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
				return character.customFieldValues.find(v => v.name === parameters.sort)?.displayValue || character.alias
		}
	}

	/**
	 * Select Character
	 * @param character A CharacterObject class instance
	 * @return {void}
	 */
	function selectCharacter(character) {
		const url = new URL(window.location);
		url.searchParams.set('selected', character?.slug)
		parameters.selected = parameters.selected === character.slug ? null : character.slug
	}

</script>



<svelte:head>
    <title>Character List</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Section gap={0} class="h-full overflow-hidden">


			<PageHeader class="px-16 py-3"
				title="Character List"
				tabs={[
					{ label: "List",		active: true },
					// { label: "Collections",	href: route('characters.collections') },
					{ label: "Settings",	href: route('characters.settings') },
				]}
				actions={[
					{ icon: "Plus", label: "New", theme: "accent", onclick: () => characters.create() },
				]}
			/>


			<CharacterControlBar class="px-16 pb-1.5"
				data={characters} project={activeProject}
				bind:query={parameters.query}
				bind:filter={parameters.filter}
				bind:sort={parameters.sort}
				bind:size={parameters.size}
				bind:layout={parameters.layout}
				bind:results
				min={4} max={8}
			/>


			<Flex align="start" class="px-16 pt-3 pb-6 overflow-y-auto">
				{#if activeProject && results.length > 0}
	
	
					<!-- Grid -->
	
					{#if parameters.layout === 'grid'}
						<CharacterGrid
							characters={results}
							cols={gridCols}
							gap={1.5}
						>
							{#snippet gridItem(character)}
								<CharacterCard
									active={parameters.selected === character.slug}
									character={character}
									subtitle={getSubtitle(character)}
									onclick={() => selectCharacter(character)}
									iconOptions={[
										{ icon: "Star", 		onclick: () => character.star(), iconWeight: character.starred ? 'fill' : 'regular' },
										{ icon: "Eye", 			href: character.routes?.show },
										{ icon: "Textbox", 		onclick: () => character.openModal('rename') },
										{ icon: "UploadSimple", onclick: () => character.openModal('setPortrait') },
										{ icon: "Trash", 		onclick: () => character.openModal('delete'), theme: "danger" },
									]}
									options={[{
										icon: 'FlagBannerFold', iconWeight: 'regular',
										label: "Factions...",
										create: () => factions.create(),
										options: [ ...factions.items.map(f => ({
											...f,
											active: f.id === character.factions?.items?.[0]?.id,
											label: f.name,
											onclick: () => character.addFaction(f)
										})) ]
									},{
										icon: 'MapPin', iconWeight: 'regular',
										label: "Location...",
										create: () => locations.create(),
										options: [ ...locations.items.map(l => ({
											...l,
											active: l.id === character.location?.id,
											label: l.name,
											onclick: () => character.setLocation(l.id)
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
										onclick: () => character.openModal('delete'),
										theme: "danger"
									}]}
								/>
							{/snippet}
						</CharacterGrid>
					
				
					<!-- Table -->
	
					{:else if parameters.layout === 'table'}
						<CharacterTable
							characters={results}
						/>
	
	
					<!-- Graph -->
	
					{:else if parameters.layout === 'graph'}
						<Empty
							containerClass="px-20 py-6"
							icon="Graph"
							message="This layout type isn't working yet. Try again later."
						/>


					{/if}
				{:else}

					<Empty
						icon="User"
						containerClass="w-full"
						message="There are no characters for this project yet."
						buttonLabel="Create one?"
						buttonClick={() => characters.create()}
					/>

				{/if}
			</Flex>
		</Section>
	{/snippet}
	{#snippet sidebar()}
		<CharacterPanel character={characters.items.find(c => c.slug === parameters.selected)} />
	{/snippet}
</AuthenticatedLayout>