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
	import Heading		from '@/Components/UI/Heading.svelte'
	import Media		from '@/Components/UI/Media.svelte'
	import PageHeader	from '@/Components/UI/PageHeader.svelte'
	import Section		from '@/Components/UI/Section.svelte'
	import ProjectCard	from '@/Components/Features/Project/ProjectCard.svelte'

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


		<!-- Tabs & Actions -->

		<PageHeader class="absolute top-0 px-20" color="bg-transparent"
			title={ activeProject ? null : "Projects" }
			tabs={ activeProject ? [
				{ label: 'Dashboard', active: true },
				{ label: 'Settings',  href: route('projects.settings') }
			] : undefined }
			actions={[
				{ icon: "X", 	label: "Deactivate",	 theme: "danger", onclick: () => active.deactivate(), 	if: !!activeProject },
				{ icon: "Plus", label: "Create Project", theme: "accent", onclick: () => projectList.create(),	if: !activeProject }
			]}
		/>
		<Stack class="h-full overflow-y-auto">
			{#if active}


				<!-- Banner Image -->

				<Section>
					<Media
						class="relative aspect-[7/3] bg-neutral-softest overflow-hidden text-neutral-softest w-full"
						media={active.getMedia('banner')}
						onclick={() => active.openModal('setBanner')}
					/>
				</Section>
	
	
				<!-- Project Header -->
	
				<Section size="7xl" class="relative mt-24">
					<Grid cols={2} gap={12}>

						<Stack gap={0}>
							<Flex align="center">
								<Heading is="h1" as="h2" heading={active.name} />
								<Button size="lg" style="soft" theme="accent" icon="Pen"   iconSize="lg" onclick={() => active.openModal('rename')} class="ml-auto" />
								<Button size="lg" style="soft" theme="danger" icon="Trash" iconSize="lg" onclick={() => active.openModal('delete')} />
							</Flex>
							<p class="font-style-large italic max-w-[65ch] text-neutral-soft">{active.type}</p>
							<Collapsible collapsed={true}
								class="max-w-[64ch] mt-6"
								collapsedClass="line-clamp-5 overflow-hidden">
								{active.description}
							</Collapsible>
						</Stack>

						<Grid cols={4} justify="center" gap={3} class="w-full">
							<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500" href={route('characters')}>
								<span class="font-style-h3 opacity-60">{active.characters?.items.length || 0}</span>
								<span class="font-style-large">Characters</span>
							</Link>
							<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
								<span class="font-style-h3 opacity-60">{active.dialogue?.items.length || 0}</span>
								<span class="font-style-large">Dialogues</span>
							</Link>
							<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
								<span class="font-style-h3 opacity-60">{active.events?.items.length || 0}</span>
								<span class="font-style-large">Events</span>
							</Link>
							<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500" href={route('factions')}>
								<span class="font-style-h3 opacity-60">{active.factions?.items.length || 0}</span>
								<span class="font-style-large">Factions</span>
							</Link>
							<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
								<span class="font-style-h3 opacity-60">{active.items?.items.length || 0}</span>
								<span class="font-style-large">Items</span>
							</Link>
							<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500" href={route('locations')}>
								<span class="font-style-h3 opacity-60">{active.locations?.items.length || 0}</span>
								<span class="font-style-large">Locations</span>
							</Link>
							<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
								<span class="font-style-h3 opacity-60">{active.mechanics?.items.length || 0}</span>
								<span class="font-style-large">Mechanics</span>
							</Link>
							<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
								<span class="font-style-h3 opacity-60">{active.quests?.items.length || 0}</span>
								<span class="font-style-large">Quests</span>
							</Link>
							<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
								<span class="font-style-h3 opacity-60">{active.wildlife?.items.length || 0}</span>
								<span class="font-style-large">Wildlife</span>
							</Link>
						</Grid>

					</Grid>
				</Section>
	
	
				{#if active.characters?.items.length > 0}
					<Section size="7xl" class="py-6">
						<Heading is="h3" as="h5" class="mb-3" heading="Recent Characters" />
						<Flex justify="start" gap={2} class="overflow-x-auto w-full">
							{#each active.characters.items as character}
								<Card
									class="flex-shrink-0 w-40"
									aspect="square"
									image={character.image?.url}
									thumbnailIcon="User"
									title={character.name}
									subtitle={character.subtitle}
									href={route('characters.show', {character: character.slug})}
								/>
							{/each}
						</Flex>
					</Section>
				{/if}


				{#if active.factions?.items.length > 0}
					<Section size="7xl" class="py-6">
						<Heading is="h3" as="h5" class="mb-3" heading="Recent Factions" />
						<Flex justify="start" gap={2} class="overflow-x-auto w-full">
							{#each active.factions.items as faction}
								<Card
									aspect="square"
									class="flex-shrink-0 w-40"
									image={faction.image?.url}
									thumbnailIcon="FlagBannerFold"
									title={faction.name}
									subtitle={faction.subtitle}
									href={route('factions.show', {faction: faction.slug})}
								/>
							{/each}
						</Flex>
					</Section>
				{/if}
	
	
				{#if active.locations?.items.length > 0}
					<Section size="7xl" class="py-6">
						<Heading is="h3" as="h5" class="mb-3" heading="Recent Locations" />
						<Flex justify="start" gap={2} class="overflow-x-auto w-full">
							{#each active.locations.items as location}
								<Card
									aspect="video"
									class="flex-shrink-0 w-56"
									image={location.image?.url}
									thumbnailIcon="MapPinArea"
									title={location.name}
									subtitle={location.subtitle}
									href={route('locations.show', {location: location.slug})}
								/>
							{/each}
						</Flex>
					</Section>
				{/if}
			{:else}
	
			
				<Section class="p-20 pt-16">
					{#if projects}
						<Grid gap={3} class="xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-1">
							{#each projectList.items as project}
								<ProjectCard
									project={project}
									onclick={() => project.activate()}
									options={[
										{ icon: 'Textbox', 	label: 'Rename', 			onclick: () => renameProject(project) },
										{ icon: 'Trash', 	label: 'Delete Project',	onclick: () => deleteProject(project), theme: 'danger' },
									]}
								/>
							{/each}
						</Grid>
					{:else}
						No projects
					{/if}
				</Section>
	

			{/if}
		</Stack>
	{/snippet}
</AuthenticatedLayout>