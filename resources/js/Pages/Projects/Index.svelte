<!-- <script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import ProjectForm from '@/Forms/ProjectForm.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import Card from '@/Components/Card.svelte'
	import Grid from '@/Components/Grid.svelte'
	import Heading from '@/Components/Heading.svelte'
	import Modal from '@/Components/Modal.svelte'
	import Panel from '@/Components/Panel'
	import Section from '@/Components/Section.svelte'

	const projects = $page.props.projects.data
	const activeProject = $page.props.activeProject.data
	const form = useForm({
        project: activeProject?.id,
    })

	let creatingProject = $state(false)

	function closeModal() {
        creatingProject = false
    }
	function createProject() {
        creatingProject = true
    }
	function activateProject(e, id) {
		e.preventDefault();
		$form.patch(route('projects.activate', { project: id }))
	}
	function deactivateProject(e) {
		e.preventDefault();
		$form.post(route('projects.deactivate'))
	}
	
</script>

<svelte:head>
    <title>Projects</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Projects"}
		]} />
		<Button style="plain" theme="accent" class="border-l rounded-none"
			icon="Plus" iconSize={24} iconWeight="light"
			onclick={createProject}
		/>
	{/snippet}

	{#snippet article()}
		<Section>
			<Heading is="h2" as="h4" class="mb-12"
				heading="Projects"
				subheading="Manage your projects and their details here."
			/>

			{#if projects}
				<Grid class="xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-1">
					{#each projects as project}
						<Card
							class="aspect-video"
							title={project.name}
							subtitle={project.description}
							image={project?.banner?.url}
							active={project.id == activeProject?.id}
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
	{/snippet}
	
</AuthenticatedLayout>

<Modal class="p-8" show={creatingProject || updatingProject} onclose={closeModal}>
	<ProjectForm project={activeProject} oncancel={closeModal} />
</Modal>

<Modal class="p-8" show={deletingProject} onclose={closeModal}>
	<DeleteProjectForm project={activeProject} oncancel={closeModal} />
</Modal> -->