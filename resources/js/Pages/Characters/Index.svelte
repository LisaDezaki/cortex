<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import Box					from '@/Components/Core/Box.svelte'
	import Flex					from '@/Components/Core/Flex.svelte'
	import Grid					from '@/Components/Core/Grid.svelte'
	import Inline				from '@/Components/Core/Inline.svelte'
	import Stack				from '@/Components/Core/Stack.svelte'
	import Button				from '@/Components/UI/Button.svelte'
	import Collapsible			from '@/Components/UI/Collapsible.svelte'
	import Empty				from '@/Components/UI/Empty.svelte'
	import Heading				from '@/Components/UI/Heading.svelte'
	import PageHeader			from '@/Components/UI/PageHeader.svelte'
	import Section				from '@/Components/UI/Section.svelte'
	import Separator			from '@/Components/UI/Separator.svelte'
	import Skeleton				from '@/Components/UI/Skeleton.svelte'
	import Tag					from '@/Components/UI/Tag.svelte'
	import Thumbnail			from '@/Components/UI/Thumbnail.svelte'
	import CharacterCard		from '@/Components/Features/Character/CharacterCard.svelte'
	import CharacterControlBar 	from '@/Components/Features/Character/CharacterControlBar.svelte'
	import CharacterGrid 		from '@/Components/Features/Character/CharacterGrid.svelte'
	import CharacterTable		from '@/Components/Features/Character/CharacterTable.svelte'


	//	Page props

	import ProjectObject 	from '@/services/ProjectObject'
	import CollectionList 	from '@/services/CollectionList'
	const activeProject	  = $state(new ProjectObject($page.props.activeProject.data))
	const collections	  = $state(new CollectionList($page.props.collections?.data))
	const customFields	  = $state($page.props.customFields?.data)
	const characters      = $state(activeProject?.characters)
	const factions    	  = $state(activeProject?.factions)
	const locations    	  = $state(activeProject?.locations)


	//	State & Derived values

	let query	 = $state('')
	let filter	 = $state('')
	let sort	 = $state('name')
	let size	 = $state(8)
	let layout	 = $state('grid')
	let selected = $state(null)
	let gridCols = $derived(14-size)
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
				return character.customFieldValues.find(v => v.name === sort)?.value || character.alias
		}
	}

	function selectCharacter(character) {
		selected = selected?.id === character?.id ? null : character
	}

</script>



<svelte:head>
    <title>Character List</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Section gap={6} class="px-20">
			<Grid cols={4} gap={20} class="gap-20">
				<Box class="col-span-3">

					<PageHeader class="sticky top-0"
						title="Character List"
						tabs={[
							{ label: "List",		active: true },
							{ label: "Collections",	href: route('characters.collections') },
							{ label: "Settings",	href: route('characters.settings') },
						]}
						actions={[
							{ icon: "Plus", theme: "accent", onclick: () => characters.create() },
						]}
					/>

					<CharacterControlBar
						data={characters} project={activeProject}
						bind:query bind:filter bind:sort
						bind:results bind:size bind:layout
					/>

					{#if activeProject && results.length > 0}
		
		
						<!-- Grid -->
		
						{#if layout === 'grid'}

							<!-- <pre>{JSON.stringify(customFields,null,2)}</pre> -->

							<CharacterGrid
								characters={results}
								class="py-3"
								cols={gridCols}
							>
								{#snippet gridItem(character)}
									<CharacterCard
										active={selected?.id === character.id}
										character={character}
										subtitle={getSubtitle(character)}
										onclick={() => selectCharacter(character)}
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
				</Box>

				<Stack class="col-span-1">
					<Stack gap={3} class="sticky top-0 h-screen pt-16 pb-6">

						{#if selected}

							<!-- <pre>{JSON.stringify(selected.customFieldValues,null,2)}</pre> -->

							<Thumbnail src={selected.image?.url} />

							<Stack>
								<Flex align="start" justify="between">
									<Heading is="h3" as="h4">{selected.name}</Heading>
									<!-- <Button style="plain" theme="neutral" icon="DotsThreeOutlineVertical" iconSize="md" iconWeight="fill" class="rounded-full hover:bg-neutral-softest" /> -->
									{#if selected.starred}
										<Button class="text-amber-400" size="none" icon="Star" iconSize="xl" iconWeight="fill" />
									{:else}
										<Button class="text-neutral-softest" size="none" icon="Star" iconSize="xl" iconWeight="light" />
									{/if}
								</Flex>
								<p class="text-sm">{selected.alias}</p>
							</Stack>

							<Collapsible class="font-style-small mb-6" collapsed={true}>
								{selected.description}
							</Collapsible>

							
							<Stack gap={3}>

								<Inline align="start" gap={0} class="text-sm">
									<span class="font-bold min-w-24 mr-2">Appearance:</span>
									<Flex wrap gap={0.5}>
										{#if selected.appearance}
											{#each selected.appearance.split(',') as trait}
												<Tag plain class="bg-neutral-softest font-style-small py-0.5">{trait}</Tag>
											{/each}
										{:else}
											<Link class="font-style-placeholder" onclick={() => selected.setAppearance()}>Not set</Link>
										{/if}
									</Flex>
								</Inline>
	
								<Inline align="start" gap={0} class="text-sm">
									<span class="font-bold min-w-24 mr-2">Personality:</span>
									<Flex wrap gap={0.5}>
										{#if selected.personality}
											{#each selected.personality.split(',') as trait}
												<Tag plain class="bg-neutral-softest font-style-small py-0.5">{trait}</Tag>
											{/each}
										{:else}
											<Link class="font-style-placeholder" onclick={() => selected.setPersonality()}>Not set</Link>
										{/if}
									</Flex>
								</Inline>

								{#each customFields as field}
									<Inline align="start" gap={0} class="text-sm">
										<span class="font-bold min-w-24 mr-2">{field?.label}:</span>
										{#if selected.customFieldValues.find(f => f.label === field.label)}
											<span>{selected.customFieldValues.find(f => f.label === field.label).displayValue}</span>
										{:else}
											<Link class="font-style-placeholder" onclick={() => selected.setCustomValue()}>Not set</Link>
										{/if}
									</Inline>
								{/each}
		
								<Inline align="start" gap={0} class="text-sm">
									<span class="font-bold min-w-24 mr-2">Factions:</span>
									{#if selected.factions?.items.length > 0}
										{#each selected.factions.items as rel, i}
											<Link class="text-accent hover:underline" href={selected.factions?.items[0]?.routes.show}>
												<span class="line-clamp-1 truncate">{selected.factions?.items[0]?.name}</span>
											</Link>
											{#if i === selected.factions.items.length - 1}{:else},&nbsp;{/if}
										{/each}
									{:else}
										<Link class="font-style-placeholder" onclick={() => selected.setFactions()}>Not set</Link>
									{/if}
								</Inline>
		
								<Inline align="start" gap={0} class="text-sm">
									<span class="font-bold min-w-24 mr-2">Location:</span>
									{#if selected.location}
										<Link class="text-accent hover:underline" href={selected.location?.routes.show}>{selected.location?.name}</Link>
									{:else}
										<Link class="font-style-placeholder" onclick={() => selected.setLocation()}>Not set</Link>
									{/if}
								</Inline>
		
								<Inline align="start" gap={0} class="text-sm">
									<span class="font-bold min-w-24 mr-2">Relationships:</span>
									{#if selected.relationships?.items.length > 0}
										{#each selected.relationships.items as rel, i}
											<Link class="text-accent hover:underline" href={rel.routes.show}>{rel.name}</Link>
											{#if i === selected.relationships.items.length - 1}{:else},&nbsp;{/if}
										{/each}
									{:else}
										<Link class="font-style-placeholder" onclick={() => selected.setRelationships()}>Not set</Link>
									{/if}
								</Inline>
							</Stack>

	
							<Button size="xl" style="hard" theme="accent" class="line-clamp-1 mt-auto"
								icon="Eye" iconWeight="fill"
								label="View {selected.name}"
								href={selected.routes.show}
							/>

						{:else}
							<Thumbnail class="mb-1" />
							<Stack gap={2}>
								<Flex align="center" justify="between">
									<Skeleton class="h-6 w-1/3" />
									<Skeleton class="h-6 w-6" />
								</Flex>
								<Skeleton class="h-3 mb-2.5 w-1/2" />
							</Stack>
							<Stack gap={2} class="mb-2">
								<Skeleton class="h-3 mr-5" />
								<Skeleton class="h-3 mr-1" />
								<Skeleton class="h-3 mr-24" />
							</Stack>
							<Skeleton class="h-3 w-16" color="bg-accent-softest" />
							<Inline class="mt-16 w-full">
								<Skeleton class="h-3 w-16 mr-3" />
								<Skeleton class="h-6 rounded-full w-6" />
								<Skeleton class="h-3 w-24" />
							</Inline>
							<Inline class="mt-2">
								<Skeleton class="h-3 w-16 mr-3" />
								<Skeleton class="h-6 rounded-full w-6" />
								<Skeleton class="h-3 w-32" />
							</Inline>
							<Inline class="mt-2">
								<Skeleton class="h-3 w-24"  />
								<Skeleton class="h-6 rounded-full w-6" />
								<Skeleton class="h-6 rounded-full w-6" />
								<Skeleton class="h-6 rounded-full w-6" />
							</Inline>
							<Skeleton class="h-[50px] mt-auto rounded-lg" />
						{/if}
					</Stack>
				</Stack>

			</Grid>
		</Section>
	{/snippet}
</AuthenticatedLayout>