<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
    import AuthenticatedLayout 	from '@/Layouts/AuthenticatedLayout.svelte'

	import Box			from '@/Components/Core/Box.svelte'
	import Flex			from '@/Components/Core/Flex.svelte'
	import Grid			from '@/Components/Core/Grid.svelte'
	import Inline		from '@/Components/Core/Inline.svelte'
	import Stack		from '@/Components/Core/Stack.svelte'

	import Background	from '@/Components/UI/Background.svelte'
	import Button		from '@/Components/UI/Button.svelte'
	import Collapsible	from '@/Components/UI/Collapsible.svelte'
	import Container	from '@/Components/UI/Container.svelte'
	import ControlBar	from '@/Components/UI/ControlBar.svelte'
	import Entity		from '@/Components/UI/Entity.svelte'
	import Heading		from '@/Components/UI/Heading.svelte'
	import Media		from '@/Components/UI/Media.svelte'
	import PageHeader	from '@/Components/UI/PageHeader.svelte'
	import PageHeading	from '@/Components/UI/PageHeading.svelte'
	import PageMenu		from '@/Components/UI/PageMenu.svelte'
	import Section		from '@/Components/UI/Section.svelte'
	import Separator	from '@/Components/UI/Separator.svelte'
	import Thumbnail	from '@/Components/UI/Thumbnail.svelte'

	import ProjectList 	 from '@/services/ProjectList'
	import ProjectObject from '@/services/ProjectObject'

	let user     		= $state($page.props.auth.user.data)
	let activeProject 	= $state($page.props.activeProject?.data)
	let projects		= $state($page.props.projects.data)

	let active			= $derived( activeProject ? new ProjectObject(activeProject) : null )
	let projectList		= $derived( projects      ? new ProjectList(projects)		 : null )

	let results			= $state(projects      ? new ProjectList(projects)		 : [])
	let layout			= $state('grid')
	let size			= $state(3)

</script>



<svelte:head>
    <title>Dashboard</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Stack class="overflow-y-auto">

			{#if active}
				<Section id="header">
					<Background
						class="aspect-video bg-no-repeat bg-center bg-cover bg-neutral-softest max-h-[60vh] overflow-hidden sticky top-0"
						onclick={() => active.openModal('setMedia', { type: 'banner', aspect: 'aspect-video'})}
						url={active.getMedia('banner')?.url}
					/>
				</Section>
				<Flex align="start" justify="center" gap={6} class="bg-surface flex-1 px-20 py-12">

					<!-- Page Menu -->

					<PageMenu class="top-12"
						back={{ text: 'All Projects', onclick: () => active.deactivate() }}
						items={[
							{ icon: "GlobeStand",	label: "Overview",		href: "#overview" },
							{ icon: "Textbox",		label: "Custom Fields",	href: "#custom"   },
							{ icon: "Trash",		label: "Delete",		onclick: () => active.openModal('delete'), theme: "danger" }
						]}
					/>
					<Container size="2xl">
						
						<!-- Project Header -->
			
						<Section class="py-6">
			
							<Stack>

								<Inline align="center">
									<Heading is="h1" as="h2">{active.name}</Heading>
									<Button class="ml-1.5 place-self-start rounded-full" icon="PencilSimple" size="xs" style="plain" theme="accent" onclick={() => active.openModal('rename')} />
									<Button class="ml-auto rounded-full" icon="GearFine" size="xl" style="soft" theme="neutral" href={route('projects.settings')} />
								</Inline>

								<Inline align="center">
									<span class="text-neutral-softer text-lg">{active.type}</span>
									<Button class="ml-1.5 rounded-full" icon="PencilSimple" size="xs" style="plain" theme="accent" onclick={() => active.openModal('type')} />
								</Inline>

								<!-- <Heading is="h3" as="h4" class="mt-9 mb-6">Details</Heading> -->
								
								<Heading is="h3" as="h5" class="mt-12 mb-3 text-neutral-soft">Description
									<Button class="ml-1.5 rounded-full text-accent" size="xs" style="plain" theme="accent" icon="PencilSimple" onclick={() => active.openModal('description')} />
								</Heading>

								<Collapsible collapsed={true}
									collapsedClass="line-clamp-5 overflow-hidden">
									{active.description}
								</Collapsible>
							</Stack>
		
							<Box class="grid grid-cols-5 py-12 w-full">

								<!-- {#each ['Characters', 'Dialogues', 'Events', 'Factions', 'Items', 'Locations', 'Mechanics', 'Quests', 'Wildlife'] as entity}
									<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500" href={route(entity.toLowerCase())}>
										<span class="font-style-h3 {!active[entity.toLowerCase()]?.items.length > 0 ? 'opacity-20' : 'opacity-60'}">{active[entity.toLowerCase()]?.items.length || 0}</span>
										<span class="font-style-regular">{entity}</span>
									</Link>
								{/each} -->

								<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500" href={route('characters')}>
									<span class="font-style-h3 {!active.characters?.items.length > 0 ? 'opacity-20' : 'opacity-60'}">{active.characters?.items.length || 0}</span>
									<span class="font-style-regular">Characters</span>
								</Link>
								<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
									<span class="font-style-h3 {!active.dialogue?.items.length > 0 ? 'opacity-20' : 'opacity-60'}">{active.dialogue?.items.length || 0}</span>
									<span class="font-style-regular">Dialogues</span>
								</Link>
								<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
									<span class="font-style-h3 {!active.events?.items.length > 0 ? 'opacity-20' : 'opacity-60'}">{active.events?.items.length || 0}</span>
									<span class="font-style-regular">Events</span>
								</Link>
								<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500" href={route('factions')}>
									<span class="font-style-h3 {!active.factions?.items.length > 0 ? 'opacity-20' : 'opacity-60'}">{active.factions?.items.length || 0}</span>
									<span class="font-style-regular">Factions</span>
								</Link>
								<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
									<span class="font-style-h3 {!active.items?.items.length > 0 ? 'opacity-20' : 'opacity-60'}">{active.items?.items.length || 0}</span>
									<span class="font-style-regular">Items</span>
								</Link>
								<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500" href={route('locations')}>
									<span class="font-style-h3 {!active.locations?.items.length > 0 ? 'opacity-20' : 'opacity-60'}">{active.locations?.items.length || 0}</span>
									<span class="font-style-regular">Locations</span>
								</Link>
								<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
									<span class="font-style-h3 {!active.mechanics?.items.length > 0 ? 'opacity-20' : 'opacity-60'}">{active.mechanics?.items.length || 0}</span>
									<span class="font-style-regular">Mechanics</span>
								</Link>
								<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
									<span class="font-style-h3 {!active.quests?.items.length > 0 ? 'opacity-20' : 'opacity-60'}">{active.quests?.items.length || 0}</span>
									<span class="font-style-regular">Quests</span>
								</Link>
								<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
									<span class="font-style-h3 {!active.wildlife?.items.length > 0 ? 'opacity-20' : 'opacity-60'}">{active.wildlife?.items.length || 0}</span>
									<span class="font-style-regular">Wildlife</span>
								</Link>
								<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
									<span class="font-style-h3 {!active.codex?.items.length > 0 ? 'opacity-20' : 'opacity-60'}">{active.codex?.items.length || 0}</span>
									<span class="font-style-regular">Codex</span>
								</Link>
							</Box>
			
						</Section>
		
						<Separator class="my-12" />
		
						{#if active.characters?.items.length > 0}
							<Section size="3xl" class="py-6 w-full">
								<Heading is="h3" as="h5" class="mb-3 text-neutral-softer">Recently updated Characters</Heading>
								<Flex justify="start" gap={2} class="pb-3 overflow-visible w-full">
									{#each active.characters.items.sort((a,b) => a.meta.updatedAt < b.meta.updatedAt ? 1 : -1) as character}
										<Entity
											aspect="aspect-square"
											entity={character}
											subtitle={character.meta.updatedAt}
											layout="stack"
											size="lg"
											href={route('characters.show', {character: character.slug})}
										/>
									{/each}
								</Flex>
							</Section>
						{/if}
		
						<Separator class="my-12" />
			
						{#if active.factions?.items.length > 0}
							<Section size="3xl" class="py-6 w-full">
								<Heading is="h3" as="h5" class="mb-3 text-neutral-softer">Recently updated Factions</Heading>
								<Flex justify="start" gap={2} class="pb-3 overflow-visible w-full">
									{#each active.factions.items.sort((a,b) => a.meta.updatedAt < b.meta.updatedAt ? 1 : -1) as faction}
										<Entity
											aspect="aspect-square"
											entity={faction}
											subtitle={faction.meta.updatedAt}
											layout="stack"
											size="lg"
											href={route('factions.show', {faction: faction.slug})}
										/>
									{/each}
								</Flex>
							</Section>
						{/if}
		
						<Separator class="my-12" />
			
						{#if active.locations?.items.length > 0}
							<Section size="3xl" class="py-6 w-full">
								<Heading is="h3" as="h5" class="mb-3 text-neutral-softer">Recently updated Locations</Heading>
								<Flex justify="start" gap={2} class="pb-3 overflow-visible w-full">
									{#each active.locations.items.sort((a,b) => a.meta.updatedAt < b.meta.updatedAt ? 1 : -1) as location}
										<Entity
											aspect="aspect-video"
											entity={location}
											subtitle={location.meta.updatedAt}
											layout="stack"
											size="xl"
											href={route('locations.show', {location: location.slug})}
										/>
									{/each}
								</Flex>
							</Section>
						{/if}
		
						<Separator class="my-12" />
					</Container>
				</Flex>

			
			{:else}

				<Section size="6xl" class="px-20 py-12">
	
					<PageHeading
						title="Projects"
						subtitle="View and manage your projects from here."
						class="mb-12"
						actions={[
							{ icon: 'Plus', text: 'New Project', onclick: () => projectList.openModal('create') }
						]}
					/>

					<ControlBar
						class="mb-3" data={projectList} bind:results
						bind:layout bind:size={size}
						filterOptions={[
							{ label: 'All Projects',	value: '*',			filterFunction: (proj) => proj },
							{ label: 'Starred',			value: 'starred',	filterFunction: (proj) => proj.starred },
						]}
						sortOptions={[
							{ label: 'By name',			value: 'name',		sortFunction: (a,b) => a.name.toLowerCase() < b.name.toLowerCase() ? -1 : 1 }
						]}
						layoutOptions={[
							{ label: 'As Grid',  		value: 'grid',			icon: 'GridFour'	},
							{ label: 'As Table', 		value: 'table', 		icon: 'Table'	  	}
						]}
						sizeOptions={{ min: 1, max: 5 }}
						resizeable={layout === 'grid'}
					/>

					<!-- <pre>{JSON.stringify(results,null,3)}</pre> -->
	
					{#if projects && layout === 'grid'}
						<Grid cols={6-size} gap={3}>
							{#each results as project}
								<Entity
									aspect="aspect-video"
									entity={project}
									onclick={() => project.activate()}
									menu={project.getActions()}
								/>
							{/each}
						</Grid>
					{:else if projects && layout === 'table'}
						<Stack>
							{#each results as project}
								<Flex align="center" justify="start" class="border-b border-neutral-softest group p-1.5">
									<Entity
										aspect="aspect-video"
										entity={project}
										layout="inline"
										size="md"
										onclick={() => project.activate()}
									/>
									<Button class="group-hover:opacity-100 ml-auto opacity-0"
										size="sm" style="soft" theme="accent"
										text="Activate" onclick={() => project.activate()}
									/>
								</Flex>
							{/each}
						</Stack>
					{:else}
						No projects
					{/if}
				</Section>

			{/if}
		</Stack>
	{/snippet}
</AuthenticatedLayout>