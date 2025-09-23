<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import { Flex, Grid, Stack } from '@/Components/Core'
	
	import Container   from '@/Components/UI/Container.svelte'
	import Heading     from '@/Components/UI/Heading.svelte'
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
    <title>Project Settings</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			title="Project Settings"
			tabs={ activeProject ? [
				{ label: 'Dashboard', href: route('dashboard') },
				{ label: 'Settings', 	active: true }
			] : undefined }
			
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
					<!-- <Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h5">Overview</Heading>
					</Flex> -->
					<Stack>
						<Heading is="h3" as="h5">Overview</Heading>
						<p>Adjust your project settings here.</p>
					</Stack>
					<!-- <ProjectForm project={activeProject} /> -->
				</Section>


				<!-- Settings -->

				<Section id="settings" class="pb-12">
					<!-- <Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h6">Settings</Heading>
					</Flex> -->
					<Stack>
						<Heading is="h3" as="h6">Settings</Heading>
						<p>Adjust your various other settings here.</p>
					</Stack>
					<!-- <ProjectSettingsForm /> -->
				</Section>


				<!-- Media -->

				<Section id="media" class="pb-12">
					<!-- <Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h6">Media</Heading>
					</Flex> -->
					<Stack>
						<Heading is="h3" as="h6">Media</Heading>
						<p>Manage the media settings for your project here.</p>
					</Stack>
					<!-- <ProjectSettingsForm /> -->
				</Section>

				<!-- Media -->

				<Section id="custom" class="pb-12">
					<!-- <Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h5">Custom Fields</Heading>
					</Flex> -->
					<Stack>
						<Heading is="h3" as="h6">Custom Fields</Heading>
						<p>Manage the custom fields for this project.</p>
					</Stack>
					<!-- <ProjectSettingsForm /> -->
				</Section>

			</Container>
		</Flex>
	{/snippet}

</AuthenticatedLayout>

<!-- <Modal class="p-6" show={deletingProject} onclose={closeModal}>
	<DeleteProjectForm project={activeProject} oncancel={closeModal} />
</Modal> -->