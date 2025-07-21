<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CreateProjectForm from '@/Forms/CreateProjectForm.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import Card from '@/Components/Card.svelte'
	import CardGrid from '@/Components/CardGrid.svelte'
	import Heading from '@/Components/Heading.svelte'
	import Modal from '@/Components/Modal.svelte'
	import Panel from '@/Components/Panel'
	import Section from '@/Components/Section.svelte'

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

<AuthenticatedLayout>

	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "User", href: "/user" },
			{ title: "Projects"}
		]} />
		<Button style="plain" theme="accent" class="border-l"
			iconSize={24} iconWeight="light" icon="Plus"
			onclick={createProject}
		/>
	{/snippet}

	{#snippet panel()}
		<Panel>
			<Panel.Item icon="UserList"   label="Profile"       href={route('profile.edit')} active={$page.url.startsWith('/user/profile')} />
			<Panel.Item icon="GlobeStand" label="Projects"      href={route('projects')}     active={$page.url.startsWith('/user/projects')} />
			<Panel.Item icon="GearFine"   label="Settings"      href={route('settings')}     active={$page.url.startsWith('/user/settings')} />
			<Panel.Item icon="SignOut"    label="Log Out"       href={route('logout')}       as="button" method="post" class="text-rose-500" />
		</Panel>
	{/snippet}

	{#snippet article()}
		<Section>
			<Heading is="h2" as="h4" class="mb-12"
				heading="Projects"
				subheading="Manage your projects and their details here."
			/>

			{#if projects}
				<CardGrid class="xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-1" items={projects}>
					{#snippet card(project)}
						<Card
							class="aspect-video"
							title={project.name}
							subtitle={project.description}
							image={project.image_path}
							active={project.id == active?.id}
							href={route('projects.show', {project: project.id})}
						/>
					{/snippet}
				</CardGrid>
			{:else}
				No projects
			{/if}
		</Section>
	{/snippet}
	
	<Modal class="p-8" show={creatingProject} onclose={closeModal}>
		<CreateProjectForm oncancel={closeModal} />
	</Modal>

</AuthenticatedLayout>