<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import ProjectForm         from '@/Forms/Project/Project.svelte'
	import ProjectSettingsForm from '@/Forms/Project/Settings.svelte'
	import DeleteProjectForm   from '@/Forms/Project/Delete.svelte'

	import { Flex, Grid, Stack } from '@/Components/Core'
	
	import Back        from '@/Components/UI/Back.svelte'
	import Button      from '@/Components/UI/Button.svelte'
	import Container   from '@/Components/UI/Container.svelte'
	import Heading     from '@/Components/UI/Heading.svelte'
	import Modal       from '@/Components/UI/Modal.svelte'
	import PageHeader  from '@/Components/UI/PageHeader.svelte'
	import PageMenu    from '@/Components/UI/PageMenu.svelte'
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

	{#snippet header()}
		<PageHeader
			breadcrumbs={[]}
			back={route('dashboard')}
			title="Project Settings"
		/>
	{/snippet}

	{#snippet article()}
		<Flex justify="center" gap={12} class="py-12">

			<PageMenu
				items={[
					{ icon: "UserList",       label: "Overview",      href: "#overview" },
					{ icon: "GearFine",       label: "Settings",      href: "#settings" },
					{ icon: "ImagesSquare",   label: "Media",         href: "#media"    },
					{ icon: "Textbox",        label: "Custom Fields", href: "#custom"   }
				]}
			/>

			<Container size="4xl">


				<!-- Details -->

				<Section id="details" class="pb-12">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h5">Overview</Heading>
					</Flex>
					<ProjectForm project={activeProject} />
				</Section>


				<!-- Settings -->

				<Section id="settings" class="pb-12">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h5">Settings</Heading>
					</Flex>
					<!-- <ProjectSettingsForm /> -->
				</Section>


				<!-- Media -->

				<Section id="media" class="pb-12">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h5">Media</Heading>
					</Flex>
					<!-- <ProjectSettingsForm /> -->
				</Section>

				<!-- Media -->

				<Section id="custom" class="pb-12">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h5">Custom Fields</Heading>
					</Flex>
					<!-- <ProjectSettingsForm /> -->
				</Section>

			</Container>
		</Flex>
	{/snippet}

</AuthenticatedLayout>

<Modal class="p-6" show={deletingProject} onclose={closeModal}>
	<DeleteProjectForm project={activeProject} oncancel={closeModal} />
</Modal>