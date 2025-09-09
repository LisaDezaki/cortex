<script>

	import { Link, page, router, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
    import AuthenticatedLayout 	from '@/Layouts/AuthenticatedLayout.svelte'
	import MediaUploadForm 		from '@/Forms/Media/Upload.svelte'
	import CreateProjectForm   	from '@/Forms/Project/Create.svelte'
	import DeleteProjectForm   	from '@/Forms/Project/Delete.svelte'
	import RenameProjectForm    from '@/Forms/Project/Rename.svelte'

	import { Flex, Grid, Stack } from '@/Components/Core'

	import Card 	  from '@/Components/UI/Card.svelte'
	import Heading    from '@/Components/UI/Heading.svelte'
	import Icon       from '@/Components/UI/Icon.svelte'
	import Media  	  from '@/Components/UI/Media.svelte'
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

	let media_banner	= $derived(activeProject.media?.filter(m => m.type === 'banner')?.[0])
	// let media_gallery	= $derived(activeProject.media)

	let selectedProject = $state(null)
	let creatingProject = $state(false)
	let renamingProject = $state(false)
	let deletingProject = $state(false)
	let settingBanner   = $state(false)

	function createProject(e, project) 	{	creatingProject = true; selectedProject = project }
	function renameProject(e, project)	{	renamingProject = true; selectedProject = project }
	function deleteProject(e, project)	{	deletingProject = true; selectedProject = project }
	function closeModal() 				{	creatingProject = false
											settingBanner   = false
											renamingProject = false
											deletingProject = false
											selectedProject = null
										}

	function activateProject(e, proj) {
		e.preventDefault();
		$form.project = proj.id
		$form.post(
			route('projects.activate', { project: proj.id }),
			{
				onSuccess: (res) => {
					router.visit($page.url, {
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
					router.visit($page.url, {
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
			title={activeProject ? "Dashboard" : "Select a Project"}
			tabs={ activeProject ? [
				{ label: 'Dashboard', active: true },
				{ label: 'Settings', 	href: route('projects.settings') }
			] : undefined }
			actions={[
				{ icon: "X", 	label: "Deactivate",	theme: "danger", onclick: deactivateProject, if: !!activeProject },
				{ icon: "Plus", label: "Create",		theme: "accent", onclick: createProject,	 if: !activeProject }
			]}
		/>
	{/snippet}

	{#snippet article()}

		{#if activeProject}

			<Section>
				<Media replaceable
					class="relative bg-neutral-softest h-[50vh] min-h-96 overflow-hidden w-full"
					endpoint={route('projects.update', { project: activeProject.id })}
					method="patch"
					media={media_banner}
					type="banner"
					reloadPageProps={['activeProject.banner', 'activeProject.media']}
				/>
			</Section>

			<Section size="7xl" class="relative pt-12">
				<Grid cols={2} gap={12}>
					<Stack>
						<Heading is="h1" as="h2" heading={activeProject.name} />
						<p class="font-style-large italic max-w-[65ch] text-neutral-soft">{activeProject.type}</p>
						<p class="max-w-[65ch] mt-6">{activeProject.description}</p>
					</Stack>
					<Grid cols={4} justify="center" gap={3} class="w-full">
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
					</Grid>
				</Grid>
			</Section>

			{#if activeProject.characters?.length > 0}
				<Section size="7xl" class="py-6">
					<Heading is="h3" as="h5" class="mb-3" heading="Recent Characters" />
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
					<Heading is="h3" as="h5" class="mb-3" heading="Recent Factions" />
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
					<Heading is="h3" as="h5" class="mb-3" heading="Recent Locations" />
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
								project={project}
								title={project.name}
								subtitle={project.type}
								image={project?.banner?.url}
								onclick={(e) => activateProject(e, project)}
								options={[
									{ icon: 'Check', 	label: 'Activate',			onclick: (e) => activateProject(e, project), theme: 'accent' },
									{ icon: 'Textbox', 	label: 'Rename', 			onclick: (e) => renameProject(e, project) },
									{ icon: 'Trash', 	label: 'Delete Project',	onclick: (e) => deleteProject(e, project), theme: 'danger' },
								]}
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


<Modal title="Create a new Project" maxWidth="lg" show={creatingProject}
	onclose={closeModal}>
	<CreateProjectForm
		onFinish={closeModal} oncancel={closeModal} />
</Modal>

<Modal title="Delete Project" maxWidth="lg" show={deletingProject}
	onclose={closeModal}>
	<DeleteProjectForm project={selectedProject}
		onFinish={closeModal} oncancel={closeModal} />
</Modal>

<Modal title="Rename Project" maxWidth="lg" show={renamingProject}
	onclose={closeModal}>
	<RenameProjectForm project={selectedProject}
		onFinish={closeModal} oncancel={closeModal} />
</Modal>

<!-- {#if activeProject}
	<Modal maxWidth="xl" show={settingBanner}
		onclose={closeModal}>
		<MediaUploadForm aspect="aspect-[7/3]" media={activeProject.banner}
			onFinish={closeModal} oncancel={closeModal} />
	</Modal>
{/if} -->