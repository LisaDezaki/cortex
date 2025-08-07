<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import DeleteProjectForm from '@/Forms/DeleteProjectForm.svelte'
	import ProjectSettingsForm from '@/Forms/ProjectSettingsForm.svelte'
	import ProjectForm from '@/Forms/ProjectForm.svelte'
	
	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import HeaderButton from '@/Components/HeaderButton.svelte'
	import Modal from '@/Components/Modal.svelte'
	import Section from '@/Components/Section.svelte'

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

	{#snippet header()}
		<Breadcrumbs data={[ { title: "Settings" } ]} />
		<HeaderButton icon="Trash" theme="danger" onclick={deleteProject} />
	{/snippet}

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