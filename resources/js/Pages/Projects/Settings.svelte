<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import ProjectForm         from '@/Forms/Project/Project.svelte'
	import ProjectSettingsForm from '@/Forms/Project/Settings.svelte'
	import DeleteProjectForm   from '@/Forms/Project/Delete.svelte'
	
	import Back        from '@/Components/UI/Back.svelte'
	import Button      from '@/Components/UI/Button.svelte'
	import Modal       from '@/Components/UI/Modal.svelte'
	import Section     from '@/Components/UI/Section.svelte'

	const activeProject = $page.props.activeProject?.data
	const form = useForm({
        project: activeProject.id,
    })

	let deletingProject = $state(false)

	function deleteProject() {
        deletingProject = true
    }
	function closeModal() {
		deletingProject = false
    }

</script>

<svelte:head>
    <title>{activeProject.name} / Project Settings</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet article()}
		<Back href="/" />

		<Section limitWidth class="space-y-6"
			title="Project Settings"
			subtitle="Manage your settings and preferences for this project."
		>
			<ProjectForm project={activeProject} />
			<ProjectSettingsForm />
		</Section>
	{/snippet}

	{#snippet sidebar()}
		<div>
			Show Characters
		</div>
		<div>
			Show Dialogue
		</div>
		<div>
			Show Events
		</div>
		<div>
			Show Factions
		</div>
		<div>
			Show Items
		</div>
		<div>
			Show Locations
		</div>
		<div>
			Show Mechanics
		</div>
		<div>
			Show Quests
		</div>
		<div>
			Show Wildlife
		</div>
		<div>
			Show Glossary
		</div>
	{/snippet}

</AuthenticatedLayout>

<Modal class="p-6" show={deletingProject} onclose={closeModal}>
	<DeleteProjectForm project={activeProject} oncancel={closeModal} />
</Modal>