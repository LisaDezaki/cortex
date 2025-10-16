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
	import Empty     		 	from '@/Components/UI/Empty.svelte'
	import Heading				from '@/Components/UI/Heading.svelte'
	import PageHeader		 	from '@/Components/UI/PageHeader.svelte'
	import Section      	 	from '@/Components/UI/Section.svelte'
	import Skeleton				from '@/Components/UI/Skeleton.svelte'
	import Tag					from '@/Components/UI/Tag.svelte'
	import Thumbnail			from '@/Components/UI/Thumbnail.svelte'
	import FactionCard 		 	from '@/Components/Features/Faction/FactionCard.svelte'
	import FactionControlBar 	from '@/Components/Features/Faction/FactionControlBar.svelte'
	import FactionGrid 		 	from '@/Components/Features/Faction/FactionGrid.svelte'
	import FactionTable 	 	from '@/Components/Features/Faction/FactionTable.svelte'


	//	Page props

	import ProjectObject 	from '@/services/ProjectObject'
	import CollectionList 	from '@/services/CollectionList'
	const activeProject   = new ProjectObject($page.props.activeProject.data)
	const collections	  = new CollectionList($page.props.collections?.data)
	const characters      = $state(activeProject?.characters)
	const factions    	  = $state(activeProject?.factions)
	const locations    	  = $state(activeProject?.locations)
	

	//	State & Derived values

	let query	 = $state('')
	let filter	 = $state('')
	let sort	 = $state('name')
	let size	 = $state(8)
	let layout   = $state('grid')
	let selected = $state(null)
	let gridCols = $derived(14-size)
	let results = $derived(factions.items)

	function getSubtitle(faction) {
		switch (sort) {
			case 'members':
				return faction.members?.items.length + ' Members'
			case 'created_at':
				return new Date(faction.meta?.createdAt).toLocaleString() || '--'
			case 'updated_at':
				return new Date(faction.meta?.updatedAt).toLocaleString() || '--'
			default:
				return faction.type
		}
	}

	function selectFaction(faction) {
		selected = selected === faction ? null : faction
	}
	
</script>



<svelte:head>
    <title>Faction List</title>
</svelte:head>

<AuthenticatedLayout>	
	{#snippet article()}
		<Section gap={6} class="px-20">
			<Grid cols={4} gap={20} class="gap-20">
				<Box class="col-span-3">

					<PageHeader class="sticky top-0"
						title="Faction List"
						tabs={[
							{ label: "List",		active: true },
							{ label: "Collections",	href: route('factions.collections') },
							{ label: "Settings",	href: route('factions.settings') },
						]}
						actions={[
							{ icon: "Plus", theme: "accent", onclick: () => factions.create() },
						]}
					/>

					<FactionControlBar
						data={factions} project={activeProject}
						bind:query bind:filter bind:sort
						bind:results bind:size bind:layout
					/>

					{#if activeProject && results.length > 0}


						<!-- Grid -->

						{#if layout == 'grid'}
							<FactionGrid
								factions={results}
								class="py-3"
								cols={gridCols}
							>
								{#snippet gridItem(faction)}
									<FactionCard
										active={selected?.id === faction.id}
										faction={faction}
										subtitle={getSubtitle(faction)}
										onclick={() => selectFaction(faction)}
										iconOptions={[
											{ icon: "Star", 		onclick: () => faction.star(), iconWeight: faction.starred ? 'fill' : 'regular' },
											{ icon: "Eye", 			href: faction.routes.show },
											{ icon: "Textbox", 		onclick: () => faction.rename() },
											{ icon: "UploadSimple", onclick: () => faction.addEmblem() },
											{ icon: "Trash", 		onclick: () => faction.delete(), theme: "danger" },
										]}
										options={[{
											
											icon: 'HouseLine', iconWeight: 'regular',
											label: "Set Headquarters",
											options: [ ...locations.items.map(l => ({
												...l,
												active: l.id === faction.headquarters?.id,
												label: l.name,
												onclick: () => faction.setHeadquarters(l)
											})) ]
										},{
											icon: 'UserPlus', iconWeight: 'regular',
											label: "Add Member",
											options: [ ...characters.items.map(c => ({
												...c,
												active: faction.members?.items.map(m => m.name.toLowerCase()).includes(c.name.toLowerCase()),
												label: c.name,
												onclick: () => faction.addMember(c)
											})) ]
										},{
											separator: true
										},{
											icon: 'FolderSimple', iconWeight: 'regular',
											label: "Add to Collection",
											create: () => collections.create(),
											options: [ ...collections.items.map(c => ({
												...c,
												label: c.name,
												onclick: () => faction.addToCollection(c),
												disabled:   c.items.map(i => i.collectionable_id).includes(faction.id),
												iconWeight: c.items.map(i => i.collectionable_id).includes(faction.id) ? 'fill' : 'light'
											}))]
										},{
											icon: 'TagSimple', iconWeight: 'regular',
											label: "Add Tags",
											onclick: () => faction.applyTags()
										},{
											separator: true
										},{
											icon: 'Trash', iconWeight: 'regular',
											label: "Delete Faction",
											onclick: () => faction.delete(),
											theme: "danger"
										}
										]}
									/>
								{/snippet}
							</FactionGrid>
						

						<!-- Table -->

						{:else if layout == 'table'}
							<FactionTable
								factions={results}
							/>


						{/if}
					{:else}

						<Empty
							icon="FlagBannerFold"
							message="There are no factions for this project yet."
							buttonLabel="Create one?"
							buttonClick={() => factions.create()}
						/>

					{/if}

				</Box>

				<Stack class="col-span-1">
					<Stack gap={3} class="sticky top-0 h-screen pt-16 pb-6">

						{#if selected}
							<Thumbnail src={selected.image?.url} />

							<Flex align="start" justify="between">
								<Stack gap={1}>
									<Heading is="h3" as="h5">{selected.name}</Heading>
									<p class="text-sm">{selected.type}</p>
								</Stack>
								<Button style="plain" theme="neutral" icon="DotsThreeOutlineVertical" iconSize="md" iconWeight="fill" class="rounded-full hover:bg-neutral-softest" />
							</Flex>

							<Collapsible class="font-style-small mb-6" collapsed={true}>
								{selected.description}
							</Collapsible>

							<Inline class="mb-1 text-sm" gap={0}>
								<span class="font-bold mr-2 w-24">Headquarters:</span>
								{#if selected.headquarters}
									<Link class="inline-flex items-center gap-1.5 border pr-3 rounded-full hover:border-accent hover:text-accent" href={selected.headquarters?.routes?.show}>
										<Thumbnail src={selected.headquarters?.image?.url} class="h-7 p-[1px] rounded-full w-7" imageClass="rounded-full" />
										<span class="line-clamp-1 truncate">{selected.headquarters?.name}</span>
									</Link>
								{/if}
							</Inline>
	
							<Inline class="mb-1 text-sm" gap={0}>
								<span class="font-bold mr-2 w-24">Members:</span>
								{#each selected.members.items as mem}
									<Link class="rounded-full" href={mem.routes.show}>
										<Thumbnail src={mem?.image?.url} class="border h-7 p-[1px] rounded-full w-7 hover:border-accent" imageClass="rounded-full" />
									</Link>
								{/each}
							</Inline>

							<Button size="xl" style="hard" theme="accent" class="line-clamp-1 mt-auto"
								icon="Eye" iconWeight="fill"
								label="View {selected.name}"
								href={selected.routes.show}
							/>
						{:else}
							<Thumbnail class="mb-5" />
							<Skeleton class="h-5 mb-1.5 w-1/2" />
							<Skeleton class="h-3 mb-5 w-1/3" />
							<Skeleton class="h-3 mb-1.5 mr-3" />
							<Skeleton class="h-3 mb-1.5 mr-1" />
							<Skeleton class="h-3 mb-1.5 mr-7" />
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
						{/if}

					</Stack>
				</Stack>

			</Grid>	
			
		</Section>
	{/snippet}
    
</AuthenticatedLayout>