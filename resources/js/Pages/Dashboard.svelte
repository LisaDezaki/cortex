<script>

	import { Link, page, router, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import ProjectForm         from '@/Forms/Project/Project.svelte'
	import DeleteProjectForm   from '@/Forms/Project/Delete.svelte'

	import { Flex, Grid } from '@/Components/Core'

	import Card 	  from '@/Components/UI/Card.svelte'
	import Heading    from '@/Components/UI/Heading.svelte'
	import Icon       from '@/Components/UI/Icon.svelte'
	import Modal      from '@/Components/UI/Modal.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import Section    from '@/Components/UI/Section.svelte'

	import ProjectCard from '@/Components/Features/Project/ProjectCard.svelte'

	let user     		= $state($page.props.auth.user.data)
	let activeProject 	= $state($page.props.activeProject?.data)
	let projects		= $state($page.props.projects.data)

	let form = useForm({
        project: null,
    })

	let creatingProject = $state(false)
	let updatingProject = $state(false)
	let deletingProject = $state(false)

	function createProject() {
        creatingProject = true
    }
	function updateProject() {
        updatingProject = true
    }
	function deleteProject() {
        deletingProject = true
    }
	function closeModal() {
		creatingProject = false
        updatingProject = false
		deletingProject = false
    }

	function activateProject(e, id) {
		e.preventDefault();
		$form.project = id
		$form.post(
			route('projects.activate', { project: id }),
			{
				onSuccess: (res) => {
					router.visit(route('dashboard'), {
						only: ['activeProject'],
					})
				}
			}
		)
	}

	function deactivateProject(e) {
		e.preventDefault();
		$form.post(
			route('projects.deactivate'),
			{
				onSuccess: (res) => {
					router.visit(route('dashboard'), {
						only: ['activeProject'],
					})
				}
			}
		)
	}

</script>

<svelte:head>
    <title>Dashboard</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[]}
			title={activeProject ? "Dashboard" : "Select a Project"}
			actions={[
				{ icon: "Plus",     theme: "accent",  onclick: updateProject },
				{ icon: "GearFine", theme: "neutral", href: route('projects.settings') }
			]}
		/>
	{/snippet}

	{#snippet article()}

		{#if activeProject}
			<Section size="full">
				<Flex align="center" justify="center" class="relative bg-neutral-softest min-h-96 h-[40vh] overflow-hidden">
					{#if activeProject?.banner}
						<img
							src={activeProject.banner.url} alt={activeProject.name}
							class="absolute object-cover w-full"
						/>
					{:else}
						<Icon class="opacity-25" name="ImageSquare" size={48} weight="light" />
					{/if}
				</Flex>
			</Section>
			<Section size="7xl" class="relative pt-12">
				<Heading is="h1" as="h2" heading={activeProject.name} />
				<p class="max-w-[65ch] my-6">{activeProject.description}</p>
				<Flex justify="center" gap={3} class="my-12 w-full">
					<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500" href={route('characters')}>
						<span class="font-style-h3 opacity-60">{activeProject.characters?.length || 0}</span>
						<span class="font-style-large">Characters</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
						<span class="font-style-h3 opacity-60">{activeProject.dialogue?.length || 0}</span>
						<span class="font-style-large">Dialogues</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
						<span class="font-style-h3 opacity-60">{activeProject.events?.length || 0}</span>
						<span class="font-style-large">Events</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500" href={route('factions')}>
						<span class="font-style-h3 opacity-60">{activeProject.factions?.length || 0}</span>
						<span class="font-style-large">Factions</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
						<span class="font-style-h3 opacity-60">{activeProject.items?.length || 0}</span>
						<span class="font-style-large">Items</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500" href={route('locations')}>
						<span class="font-style-h3 opacity-60">{activeProject.locations?.length || 0}</span>
						<span class="font-style-large">Locations</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
						<span class="font-style-h3 opacity-60">{activeProject.mechanics?.length || 0}</span>
						<span class="font-style-large">Mechanics</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
						<span class="font-style-h3 opacity-60">{activeProject.quests?.length || 0}</span>
						<span class="font-style-large">Quests</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 w-full hover:bg-emerald-500/10 hover:text-emerald-500">
						<span class="font-style-h3 opacity-60">{activeProject.wildlife?.length || 0}</span>
						<span class="font-style-large">Wildlife</span>
					</Link>
				</Flex>
			</Section>

			{#if activeProject.characters?.length > 0}
				<Section size="7xl" class="py-6">
					<Heading is="h3" as="h5" heading="Recent Characters" />
					<Flex justify="start" gap={2} class="overflow-x-auto w-full">
						{#each activeProject.characters as character}
							<Card
								class="flex-shrink-0 w-32"
								aspect="square"
								image={character.portrait?.url}
								icon="User"
								title={character.name}
								subtitle={character.subtitle}
								href={route('characters.show', {character: character.slug})}
							/>
						{/each}
					</Flex>
				</Section>
			{/if}

			{#if activeProject.factions?.length > 0}
				<Section size="7xl" class="py-6">
					<Heading is="h3" as="h5" heading="Recent Factions" />
					<Flex justify="start" gap={2} class="overflow-x-auto w-full">
						{#each activeProject.factions as faction}
							<Card
								aspect="square"
								class="flex-shrink-0 w-32"
								image={faction.emblem?.url}
								icon="FlagBannerFold"
								title={faction.name}
								subtitle={faction.subtitle}
								href={route('factions.show', {faction: faction.slug})}
							/>
						{/each}
					</Flex>
				</Section>
			{/if}

			{#if activeProject.locations?.length > 0}
				<Section size="7xl" class="py-6">
					<Heading is="h3" as="h5" heading="Recent Locations" />
					<Flex justify="start" gap={2} class="overflow-x-auto w-full">
						{#each activeProject.locations as location}
							<Card
								aspect="video"
								class="flex-shrink-0 w-56"
								image={location.banner?.url}
								icon="MapPinArea"
								title={location.name}
								subtitle={location.subtitle}
								href={route('locations.show', {location: location.slug})}
							/>
						{/each}
					</Flex>
				</Section>
			{/if}
		{:else}
			<Section class="px-12 py-12">
				{#if projects}
					<Grid gap={3} class="xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-1">
						{#each projects as project}
							<ProjectCard
								class="aspect-video"
								title={project.name}
								subtitle={project.type}
								image={project?.banner?.url}
								onclick={
									project.id == activeProject?.id
										? (e) => deactivateProject(e)
										: (e) => activateProject(e, project.id)
								}
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

<Modal show={creatingProject || updatingProject} onclose={closeModal}>
	<ProjectForm project={activeProject} oncancel={closeModal} />
</Modal>

{#if activeProject}
	<Modal title="Delete {activeProject.name}" show={deletingProject} onclose={closeModal}>
		<DeleteProjectForm project={activeProject} oncancel={closeModal} />
	</Modal>
{/if}