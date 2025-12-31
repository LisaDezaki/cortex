<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
    import AuthenticatedLayout 	from '@/Layouts/AuthenticatedLayout.svelte'

	import Flex			from '@/Components/Core/Flex.svelte'
	import Grid			from '@/Components/Core/Grid.svelte'
	import Stack		from '@/Components/Core/Stack.svelte'

	import Button		from '@/Components/UI/Button.svelte'
	import Card			from '@/Components/UI/Card.svelte'
	import Collapsible	from '@/Components/UI/Collapsible.svelte'
	import ControlBarGeneric	from '@/Components/UI/ControlBarGeneric.svelte'
	import Entity		from '@/Components/UI/Entity.svelte'
	import Heading		from '@/Components/UI/Heading.svelte'
	import Media		from '@/Components/UI/Media.svelte'
	import PageHeader	from '@/Components/UI/PageHeader.svelte'
	import PageHeading	from '@/Components/UI/PageHeading.svelte'
	import PageMenu		from '@/Components/UI/PageMenu.svelte'
	import Section		from '@/Components/UI/Section.svelte'
	import Separator	from '@/Components/UI/Separator.svelte'

	import ProjectList 	 from '@/services/ProjectList'
	import ProjectObject from '@/services/ProjectObject'

	let user     		= $state($page.props.auth.user.data)
	let activeProject 	= $state($page.props.activeProject?.data)
	let projects		= $state($page.props.projects.data)

	let active			= $derived( activeProject ? new ProjectObject(activeProject) : null )
	let projectList		= $derived( projects      ? new ProjectList(projects)		 : null )

	let results			= $state(projects      ? new ProjectList(projects)		 : [])

</script>



<svelte:head>
    <title>Dashboard</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		{#if active}

			<PageHeader size="7xl" class="px-20 py-2"
				back={() => active.deactivate()}
				backLabel="All Projects"
				tabs={[
					{ text: 'Dashboard', active: true },
					{ text: 'Settings',  href: route('projects.settings') }
				]}
			/>
			
			<Stack class="flex-1 overflow-y-auto">

				<Section>
					<Media
						class="relative aspect-[7/3] bg-neutral-softest max-h-[60vh] overflow-hidden text-neutral-softest w-full hover:inner-shadow-lg transition-all"
						media={active.getMedia('banner')}
						onclick={() => active.openModal('setMedia', { type: 'banner', aspect: 'aspect-[7/3]'})}
					/>
				</Section>

				<Flex align="start" justify="center" gap={12} class="flex-1 px-20 py-12">
					<PageMenu
						backTo={route('characters')} backToLabel="All Projects"
						items={[
							{ icon: "GlobeStand",     label: "Overview",      href: "#overview" },
							{ icon: "Textbox",        label: "Custom Fields", href: "#custom"   },
						]}
					/>
					<Stack class="flex-1 max-w-5xl">
						
						<!-- Project Header -->
			
						<Section size="5xl" class="px-12 py-6 w-full">
							<Flex gap={20}>
			
								<Stack gap={0} class="w-2/3">
									<Flex align="start" gap={3}>
										<PageHeading as="h2"
											title={active.name}
											subtitle={active.type}
										/>
									</Flex>
									<Collapsible collapsed={true}
										class="max-w-[64ch] mt-6 text-lg"
										collapsedClass="line-clamp-5 overflow-hidden">
										{active.description}
									</Collapsible>
								</Stack>
			
								<Grid cols={3} justify="center" gap={1.5} class="w-1/3">
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
								</Grid>
			
							</Flex>
						</Section>
		
						<Separator class="my-12" />
		
						{#if active.characters?.items.length > 0}
							<Section size="5xl" class="px-12 py-6 w-full">
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
							<Section size="5xl" class="px-12 py-6 w-full">
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
							<Section size="5xl" class="px-12 py-6 w-full">
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
					</Stack>
				</Flex>
			</Stack>


			
		{:else}

			<Stack class="flex-1 overflow-y-auto">
				<Section size="7xl" class="px-20 py-12">
	
					<PageHeading
						title="Projects"
						subtitle="View and manage your projects from here."
						class="mb-12"
						actions={[
							{ icon: 'Plus', text: 'New Project', onclick: () => projectList.create() }
						]}
					/>

					<ControlBarGeneric
						class="mb-3" data={projectList} bind:results
						filterOptions={[
							{ label: 'All Projects',	value: '*',			filterFunction: (proj) => proj },
							{ label: 'Starred',			value: 'starred',	filterFunction: (proj) => proj.starred },
						]}
						sortOptions={[
							{ label: 'By name',			value: 'name',		sortFunction: (a,b) => a.name.toLowerCase() < b.name.toLowerCase() ? -1 : 1 }
						]}
						layoutOptions={[
							
						]}
					/>

					<!-- <pre>{JSON.stringify(results,null,3)}</pre> -->
	
					{#if projects}
						<Grid gap={3} class="xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-1">
							{#each projectList.items as project}
								<Entity
									aspect="aspect-video"
									entity={project}
									layout="stack"
									size="auto"
									onclick={() => project.activate()}
								/>
							{/each}
						</Grid>
					{:else}
						No projects
					{/if}
				</Section>
			</Stack>

		{/if}
		
	{/snippet}
</AuthenticatedLayout>