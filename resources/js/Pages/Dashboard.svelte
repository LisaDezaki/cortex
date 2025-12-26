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
	import Entity		from '@/Components/UI/Entity.svelte'
	import Heading		from '@/Components/UI/Heading.svelte'
	import Media		from '@/Components/UI/Media.svelte'
	import PageHeader	from '@/Components/UI/PageHeader.svelte'
	import PageHeading	from '@/Components/UI/PageHeading.svelte'
	import Section		from '@/Components/UI/Section.svelte'
	import Separator	from '@/Components/UI/Separator.svelte'

	import ProjectList 	 from '@/services/ProjectList'
	import ProjectObject from '@/services/ProjectObject'

	let user     		= $state($page.props.auth.user.data)
	let activeProject 	= $state($page.props.activeProject?.data)
	let projects		= $state($page.props.projects.data)

	let active			= $derived( activeProject ? new ProjectObject(activeProject) : null )
	let projectList		= $derived( projects      ? new ProjectList(projects)		 : null )

</script>



<svelte:head>
    <title>Dashboard</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<PageHeader size="7xl" class="px-20 py-2"
			tabs={ activeProject ? [
				{ text: 'Dashboard', active: true },
				{ text: 'Settings',  href: route('projects.settings') }
			] : undefined }
			actions={[
				{ icon: "X", 	text: "Deactivate",	 	theme: "danger", onclick: () => active.deactivate(), 	if: !!activeProject },
				{ icon: "Plus", text: "Create Project", theme: "accent", onclick: () => projectList.create(),	if: !activeProject }
			]}
		/>

		{#if active}

			<Stack class="h-full overflow-y-auto">
				
				<!-- Banner Image -->
	
				<Section class="mb-16">
					<Media
						class="relative aspect-[7/3] bg-neutral-softest max-h-[60vh] overflow-hidden text-neutral-softest w-full hover:inner-shadow-lg transition-all"
						media={active.getMedia('banner')}
						onclick={() => active.openModal('setMedia', { type: 'banner', aspect: 'aspect-[7/3]'})}
					/>
				</Section>
	
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
					<Section size="5xl" class="px-6 py-6">
						<Heading is="h3" as="h5" class="mb-3 text-neutral-softer">Recently updated Characters</Heading>
						<Flex justify="start" gap={2} class="overflow-x-auto w-full">
							{#each active.characters.items.sort((a,b) => a.meta.updatedAt < b.meta.updatedAt ? 1 : -1) as character}
								<Card
									class="flex-shrink-0 w-40"
									aspect="square"
									image={character.image?.url}
									thumbnailIcon="User"
									title={character.name}
									subtitle={character.meta.updatedAt}
									href={route('characters.show', {character: character.slug})}
								/>
							{/each}
						</Flex>
					</Section>
				{/if}
	
				{#if active.factions?.items.length > 0}
					<Section size="5xl" class="px-20 py-6">
						<Heading is="h3" as="h5" class="mb-3 text-neutral-softer">Recently updated Factions</Heading>
						<Flex justify="start" gap={2} class="overflow-x-auto w-full">
							{#each active.factions.items.sort((a,b) => a.meta.updatedAt < b.meta.updatedAt ? 1 : -1) as faction}
								<Card
									aspect="square"
									class="flex-shrink-0 w-40"
									image={faction.image?.url}
									thumbnailIcon="FlagBannerFold"
									title={faction.name}
									subtitle={faction.meta.updatedAt}
									href={route('factions.show', {faction: faction.slug})}
								/>
							{/each}
						</Flex>
					</Section>
				{/if}
	
				{#if active.locations?.items.length > 0}
					<Section size="5xl" class="px-20 py-6">
						<Heading is="h3" as="h5" class="mb-3 text-neutral-softer">Recently updated Locations</Heading>
						<Flex justify="start" gap={2} class="overflow-x-auto w-full">
							{#each active.locations.items.sort((a,b) => a.meta.updatedAt < b.meta.updatedAt ? 1 : -1) as location}
								<Card
									aspect="video"
									class="flex-shrink-0 w-56"
									image={location.image?.url}
									thumbnailIcon="MapPinArea"
									title={location.name}
									subtitle={location.meta.updatedAt}
									href={route('locations.show', {location: location.slug})}
								/>
							{/each}
						</Flex>
					</Section>
				{/if}
			</Stack>


		{:else}

		
			<Section size="7xl" class="px-20">

				<PageHeading
					title="Projects"
					subtitle="View and manage your projects from here."
					class="mb-12"
				/>

				{#if projects}
					<Grid gap={6} class="xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-1">
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

		{/if}
	{/snippet}
</AuthenticatedLayout>