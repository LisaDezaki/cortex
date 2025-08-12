<script>

	import { Link, page, router, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import ProjectForm         from '@/Forms/Project/Project.svelte'
	import DeleteProjectForm   from '@/Forms/Project/Delete.svelte'

	import { Flex, Grid } from '@/Components/Core'

	import Card 	from '@/Components/UI/Card.svelte'
	import Heading  from '@/Components/UI/Heading.svelte'
	import Icon     from '@/Components/UI/Icon.svelte'
	import Modal    from '@/Components/UI/Modal.svelte'
	import Section  from '@/Components/UI/Section.svelte'
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

	{#snippet article()}

		{#if activeProject}
			<Flex align="center" justify="center" class="relative bg-neutral-softest mb-12 min-h-96 h-[40vh] overflow-hidden">
				{#if activeProject.banner}
					<img
						src={activeProject.banner.url} alt={activeProject.name}
						class="absolute object-cover w-full"
					/>
				{:else}
					<Icon class="opacity-25" name="ImageSquare" size={48} weight="light" />
				{/if}
			</Flex>

			<Section class="relative">
				<Heading is="h2" as="h3"
					eyebrowIcon="GlobeStand"
					eyebrow="Project"
					heading={activeProject.name}
					subheading={activeProject.type}
					actions={[
						{ label: "Edit",       icon: "Pen",   onclick: updateProject },
						{ label: "Delete",     icon: "Trash", onclick: deleteProject, theme: "danger" }
					]}
				/>
				<p class="max-w-[65ch] my-6">{activeProject.description}</p>
				<Flex justify="around" gap={3} class="my-12 w-full">
					<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500" href={route('characters')}>
						<span class="font-style-h1 opacity-60">{activeProject.characters?.length || 0}</span>
						<span class="font-style-large">Characters</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
						<span class="font-style-h1 opacity-60">{activeProject.dialogue?.length || 0}</span>
						<span class="font-style-large">Dialogues</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
						<span class="font-style-h1 opacity-60">{activeProject.events?.length || 0}</span>
						<span class="font-style-large">Events</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500" href={route('factions')}>
						<span class="font-style-h1 opacity-60">{activeProject.factions?.length || 0}</span>
						<span class="font-style-large">Factions</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
						<span class="font-style-h1 opacity-60">{activeProject.items?.length || 0}</span>
						<span class="font-style-large">Items</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500" href={route('locations')}>
						<span class="font-style-h1 opacity-60">{activeProject.locations?.length || 0}</span>
						<span class="font-style-large">Locations</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
						<span class="font-style-h1 opacity-60">{activeProject.mechanics?.length || 0}</span>
						<span class="font-style-large">Mechanics</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
						<span class="font-style-h1 opacity-60">{activeProject.quests?.length || 0}</span>
						<span class="font-style-large">Quests</span>
					</Link>
					<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
						<span class="font-style-h1 opacity-60">{activeProject.wildlife?.length || 0}</span>
						<span class="font-style-large">Wildlife</span>
					</Link>
				</Flex>
			</Section>

			{#if activeProject.characters?.length > 0}
				<Section title="Recent Characters">
					<Flex justify="start" gap={2} class="pb-3 overflow-x-auto w-full">
						{#each activeProject.characters as character}
							<Card
								class="flex-shrink-0 w-40"
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
				<Section title="Recent Factions">
					<Flex justify="start" gap={2} class="pb-3 overflow-x-auto w-full">
						{#each activeProject.factions as faction}
							<Card
								aspect="square"
								class="flex-shrink-0 w-40"
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
				<Section title="Recent Locations">
					<Flex justify="start" gap={2} class="pb-3 overflow-x-auto w-full">
						{#each activeProject.locations as location}
							<Card
								aspect="video"
								class="flex-shrink-0 w-72"
								image={location.banner?.url}
								icon="MapPin"
								title={location.name}
								subtitle={location.subtitle}
								href={route('locations.show', {location: location.slug})}
							/>
						{/each}
					</Flex>
				</Section>
			{/if}
		{:else}
			<Section>
				<Heading is="h2" as="h4" class="mb-12"
					heading="Projects"
					subheading="Manage your projects and their details here."
				/>

				{#if projects}
					<Grid class="xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-1">
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