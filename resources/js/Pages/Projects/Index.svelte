<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
    import UserLayout from '@/Layouts/UserLayout.svelte'
	import CreateProjectForm from './Partials/CreateProjectForm.svelte'
	import Article from '@/Components/Article.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import Card from '@/Components/Card.svelte'
	import Modal from '@/Components/Modal.svelte'

	let projects = $page.props.projects.data
	let active   = $page.props.active_project.data

	let creatingProject = $state(false)

	function closeModal() {
        creatingProject = false
    }

	function createProject() {
        creatingProject = true
    }
	
</script>

<svelte:head>
    <title>Projects</title>
</svelte:head>

<UserLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "User", href: "/user" },
			{ title: "Projects"}
		]} />
	{/snippet}

	<section class="grid grid-cols-5 gap-12 px-12 py-6">
		<div class="col-span-3 space-y-6">

			<Article
				title="Projects"
				subtitle="Manage your projects and their details here."
				bodyclass="grid xl:grid-cols-2 md:grid-cols-1 gap-3 mt-6 px-6"
			>
				{#if projects}
					{#each projects as project}
						<Card
							class="aspect-video"
							title={project.name}
							subtitle={project.description}
							image={project.image_path}
							active={project.id == active?.id}
							href={route('projects.show', {project: project.id})}
						/>
					{/each}
				{:else}
					No projects
				{/if}
			</Article>

		</div>
		<div class="col-span-2 space-y-6">

			<Button
				primary
				class="w-full"
				icon="Plus"
				label="Start a new project"
				onclick={createProject}
			/>

		</div>

		<Modal class="p-8" show={creatingProject} onclose={closeModal}>
			<CreateProjectForm oncancel={closeModal} />
		</Modal>

	</section>
    
</UserLayout>