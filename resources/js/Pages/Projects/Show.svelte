<!-- <script>

	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import ProjectForm   from '@/Forms/ProjectForm.svelte'
	import DeleteProjectForm   from '@/Forms/DeleteProjectForm.svelte'

	import Breadcrumbs 	from '@/Components/Breadcrumbs.svelte'
	import Button		from '@/Components/Button.svelte'
	import Card 		from '@/Components/Card.svelte'
	import Heading     	from '@/Components/Heading.svelte'
	import Modal       	from '@/Components/Modal.svelte'
	import Section     	from '@/Components/Section.svelte'

	const project = $page.props.project.data

	let updatingProject = $state(false)
	let deletingProject = $state(false)

	const form = useForm({
        project: project?.id,
    })

	// function activateProject(e) {
	// 	e.preventDefault();
	// 	$form.patch(route('projects.activate', { project: project.id }))
	// }
	// function deactivateProject(e) {
	// 	e.preventDefault();
	// 	$form.post(route('projects.deactivate'))
	// }
	// function updateProject() {
    //     updatingProject = true
    // }
	function deleteProject() {
        deletingProject = true
    }
	function closeModal() {
        updatingProject = false
		deletingProject = false
    }

</script>

<svelte:head>
    <title>{project?.name} Dashboard</title>
</svelte:head>

<AuthenticatedLayout>

    {#snippet header()}
		<Breadcrumbs data={[
			{ title: project?.name },
		]} />
		<Button style="plain" theme="neutral" class="border-l rounded-none"
			icon="GearFine" iconSize={24} iconWeight="light"
			href={route('projects.settings')}
		/>
		<Button style="plain" theme="danger" class="border-l rounded-none"
			icon="Trash" iconSize={24} iconWeight="light"
			onclick={deleteProject}
		/>
    {/snippet}

	{#snippet article()}

		<div class="relative flex items-center justify-center mb-12 w-full h-[40vh] bg-slate-500/10 overflow-hidden">
			{#if project.banner}
				<img
					src={project.banner.url} alt={project.name}
					class="absolute object-cover w-full"
				/>
			{/if}
		</div>

		<Section>
			<Heading is="h2" as="h3"
				heading="Dashboard"
				subheading="Manage your project"
			/>
			<div class="flex justify-around gap-3 my-12 w-full">

				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500" href={route('characters')}>
					<span class="font-style-h1 opacity-60">{project.characters?.length || 0}</span>
					<span class="font-style-large">Characters</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
					<span class="font-style-h1 opacity-60">{project.dialogue?.length || 0}</span>
					<span class="font-style-large">Dialogues</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
					<span class="font-style-h1 opacity-60">{project.events?.length || 0}</span>
					<span class="font-style-large">Events</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500" href={route('factions')}>
					<span class="font-style-h1 opacity-60">{project.factions?.length || 0}</span>
					<span class="font-style-large">Factions</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
					<span class="font-style-h1 opacity-60">{project.items?.length || 0}</span>
					<span class="font-style-large">Items</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500" href={route('locations')}>
					<span class="font-style-h1 opacity-60">{project.locations?.length || 0}</span>
					<span class="font-style-large">Locations</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
					<span class="font-style-h1 opacity-60">{project.mechanics?.length || 0}</span>
					<span class="font-style-large">Mechanics</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
					<span class="font-style-h1 opacity-60">{project.quests?.length || 0}</span>
					<span class="font-style-large">Quests</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
					<span class="font-style-h1 opacity-60">{project.wildlife?.length || 0}</span>
					<span class="font-style-large">Wildlife</span>
				</Link>
			</div>
		</Section>

		{#if project.characters?.length > 0}
			<Section
				title="{project.name} Characters"
				subtitle="{project.characters?.length} characters"
			>
				<div items={project.characters} class="flex justify-start gap-2 pb-3 overflow-x-auto w-full">
					{#each project.characters as character}
						<Card
							class="aspect-[3/4] w-32 flex-shrink-0"
							image={character.image_path}
							icon="User"
							title={character.name}
							subtitle={character.subtitle}
							href={route('characters.show', {character: character.slug})}
						/>
					{/each}
				</div>
			</Section>
		{/if}

		{#if project.factions?.length > 0}
			<Section
				title="{project.name} Factions"
				subtitle="{project.factions?.length} factions"
			>
				<div items={project.factions} class="flex justify-start gap-2 pb-3 overflow-x-auto w-full">
					{#each project.factions as faction}
						<Card
							class="aspect-square w-36 flex-shrink-0"
							image={faction.image_path}
							icon="FlagBannerFold"
							title={faction.name}
							subtitle={faction.subtitle}
							href={route('factions.show', {faction: faction.slug})}
						/>
					{/each}
				</div>
			</Section>
		{/if}

		{#if project.locations?.length > 0}
			<Section
				title="{project.name} Locations"
				subtitle="{project.locations?.length} locations"
			>
				<div items={project.locations} class="flex justify-start gap-2 pb-3 overflow-x-auto w-full">
					{#each project.locations as location}
						<Card
							class="aspect-video w-56 flex-shrink-0"
							image={location.banner_path}
							icon="MapPin"
							title={location.name}
							subtitle={location.subtitle}
							href={route('locations.show', {location: location.slug})}
						/>
					{/each}
				</div>
			</Section>
		{/if}

	{/snippet}
	
</AuthenticatedLayout>

<Modal class="p-8" show={updatingProject} onclose={closeModal}>
	<ProjectForm project={project} oncancel={closeModal} />
</Modal>

<Modal class="p-8" show={deletingProject} onclose={closeModal}>
	<DeleteProjectForm project={project} oncancel={closeModal} />
</Modal> -->