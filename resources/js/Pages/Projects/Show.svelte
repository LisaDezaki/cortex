<script>
	
	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import UserLayout from '@/Layouts/UserLayout.svelte'
	import UpdateProjectForm from './Partials/UpdateProjectForm.svelte'
	import DeleteProjectForm from './Partials/DeleteProjectForm.svelte'
	import Article from '@/Components/Article.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Modal from '@/Components/Modal.svelte';

	let active  = $page.props.active_project?.data
	let project = $page.props.project.data

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

	const form = useForm({
        project: project.id,
    })
	// function activateProject(e) {
	// 	e.preventDefault();
	// 	$form.patch(route('projects.activate', { project: project.id }))
	// }
	// function deactivateProject(e) {
	// 	e.preventDefault();
	// 	$form.post(route('projects.deactivate'))
	// }

</script>

<svelte:head>
    <title>{project.name}</title>
</svelte:head>

<UserLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "User", href: "/user" },
			{ title: "Projects", href: "/user/projects"},
			{ title: project.name }
		]} />
	{/snippet}

	<section class="grid grid-cols-5 gap-12 px-12 py-6">
		<div class="col-span-3 space-y-6">

			<Article class="px-6 py-3 space-y-3">
	
				<div class="-space-y-1">
					<span class="font-style-button">Project</span>
					<h2 class="font-style-h4">{project.name}</h2>
				</div>

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
			</Article>

		</div>
		<div class="col-span-2 space-y-6">

			<div class="flex gap-3">
				{#if project.id == active?.id}
					<Button
						secondary
						icon="X"
						label="Deactivate Project"
						onclick={deactivateProject}
						class="bg-emerald-500/20 flex p-2 rounded-lg rounded-r-none text-emerald-500 w-full"
					/>
				{:else}
					<Button
						secondary
						icon="CheckFat"
						label="Activate Project"
						onclick={activateProject}
						class="bg-emerald-500/20 flex p-2 rounded-lg rounded-r-none text-emerald-500 w-full"
					/>
				{/if}
				<Button
					primary
					icon="Pen"
					label="Edit Project"
					onclick={updateProject}
					class="bg-emerald-500/20 flex p-2 rounded-lg rounded-r-none text-emerald-500 w-full"
				/>
				<Button
					danger
					icon="Trash"
					onclick={deleteProject}
					class="bg-rose-500/20 flex p-2 rounded-lg rounded-l-none text-rose-500"
				/>
			</div>

			<Article>
				<img src={project.image_path} alt={project.name} class="rounded-t-lg w-full" />

				<div class="p-6">
					<p>{project.description}</p>
				</div>

			</Article>
		</div>
		
	</section>

	<Modal class="p-8" show={updatingProject} onclose={closeModal}>
		<UpdateProjectForm {project} oncancel={closeModal} />
	</Modal>

	<Modal class="p-8" show={deletingProject} onclose={closeModal}>
		<DeleteProjectForm {project} oncancel={closeModal} />
	</Modal>
    
</UserLayout>