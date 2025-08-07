<!-- <script>
	
	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import ProjectForm from '@/Forms/ProjectForm.svelte'
	import DeleteProjectForm from '@/Forms/DeleteProjectForm.svelte'
	
	import Article from '@/Components/Article.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Heading from '@/Components/Heading.svelte';
	import Modal from '@/Components/Modal.svelte';
	import Section from '@/Components/Section.svelte';

	const activeProject = $page.props.activeProject?.data
	const project = $page.props.project.data
	const form = useForm({
        project: project.id,
    })

	let updatingProject = $state(false)
	let deletingProject = $state(false)

	function activateProject(e) {
		e.preventDefault();
		$form.patch(route('projects.activate', { project: project.id }))
	}
	function deactivateProject(e) {
		e.preventDefault();
		$form.post(route('projects.deactivate'))
	}
	function updateProject() {
        updatingProject = true
    }
	function deleteProject() {
        deletingProject = true
    }
	function closeModal() {
        updatingProject = false
		deletingProject = false
    }

</script>

<svelte:head>
    <title>{project.name}</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "User", href: "/user" },
			{ title: "Projects", href: "/user/projects"},
			{ title: project.name }
		]} />
		<Button style="plain" theme="accent" class="border-l rounded-none"
			icon={project.id !== active?.id ? 'CheckFat' : 'X'} iconSize={24} iconWeight="light"
			onclick={project.id !== active?.id ? activateProject : deactivateProject}
		/>
		<Button style="plain" theme="neutral" class="border-l rounded-none"
			icon="Pen" iconSize={24} iconWeight="light"
			onclick={updateProject}
		/>
		<Button style="plain" theme="danger" class="border-l rounded-none"
			icon="Trash" iconSize={24} iconWeight="light"
			onclick={deleteProject}
		/>
	{/snippet}

	{#snippet article()}
		<Section>
			<Heading is="h2" as="h4"
				heading={project.name}
				subheading="Project Information"
			/>
			<div class="flex justify-around gap-3 w-full">
				<Link class="flex flex-col items-center justify-center rounded p-1 w-full hover:bg-slate-500/10 hover:text-emerald-500" href={route('characters')}>
					<span class="font-style-h3 opacity-60">{project.characters?.length || 0}</span>
					<span class="font-style-button">Characters</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-1 w-full hover:bg-slate-500/10 hover:text-emerald-500">
					<span class="font-style-h3 opacity-60">{project.dialogue?.length || 0}</span>
					<span class="font-style-button">Dialogues</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-1 w-full hover:bg-slate-500/10 hover:text-emerald-500">
					<span class="font-style-h3 opacity-60">{project.events?.length || 0}</span>
					<span class="font-style-button">Events</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-1 w-full hover:bg-slate-500/10 hover:text-emerald-500" href={route('factions')}>
					<span class="font-style-h3 opacity-60">{project.factions?.length || 0}</span>
					<span class="font-style-button">Factions</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-1 w-full hover:bg-slate-500/10 hover:text-emerald-500" href={route('locations')}>
					<span class="font-style-h3 opacity-60">{project.locations?.length || 0}</span>
					<span class="font-style-button">Locations</span>
				</Link>
			</div>
		</Section>
	{/snippet}

	{#snippet sidebar()}

		<img src={project.image_path} alt={project.name} class="mb-4 rounded-lg w-full" />

		<div>
			<p>{project.description}</p>
		</div>

	{/snippet}
    
</AuthenticatedLayout>

<Modal class="p-8" show={updatingProject} onclose={closeModal}>
	<ProjectForm {project} oncancel={closeModal} />
</Modal>

<Modal class="p-8" show={deletingProject} onclose={closeModal}>
	<DeleteProjectForm {project} oncancel={closeModal} />
</Modal> -->