<script>
	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import { Flex, Grid, Stack } from '@/Components/Core'
	
	import Container   from '@/Components/UI/Container.svelte'
	import Heading     from '@/Components/UI/Heading.svelte'
	import PageHeader  from '@/Components/UI/PageHeader.svelte'
	import PageMenu    from '@/Components/UI/PageMenu.svelte'
	import Section     from '@/Components/UI/Section.svelte'

	import ProjectList 	 from '@/services/ProjectList'
	import ProjectObject from '@/services/ProjectObject'

	// const activeProject = $page.props.activeProject?.data
	let activeProject 	= $state($page.props.activeProject?.data)
	let active			= $derived( activeProject ? new ProjectObject(activeProject) : null )
	// const form = useForm({
    //     project: activeProject.id,
    // })

	// let deletingProject = $state(false)

	// function deleteProject() {
    //     deletingProject = true
    // }
	// function closeModal() {
	// 	deletingProject = false
    // }

</script>

<svelte:head>
    <title>Project Settings</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet article()}

		<PageHeader class="px-20 py-2"
			title={ activeProject ? null : "Projects" }
			tabs={ activeProject ? [
				{ label: 'Dashboard', href: route('dashboard') },
				{ label: 'Settings',  active: true }
			] : undefined }
			actions={[
				{ icon: "X", 	label: "Deactivate",	 theme: "danger", onclick: () => active.deactivate(), 	if: !!activeProject },
				{ icon: "Plus", label: "Create Project", theme: "accent", onclick: () => projectList.create(),	if: !activeProject }
			]}
		/>

		<Flex justify="center" gap={12} class="py-12">

			<PageMenu
				items={[
					{ icon: "UserList",       label: "Overview",      href: "#overview" },
					{ icon: "GearFine",       label: "Settings",      href: "#settings" },
					{ icon: "ImagesSquare",   label: "Media",         href: "#media"    },
					{ icon: "Textbox",        label: "Custom Fields", href: "#custom"   },
					{ icon: "Trash",	 	  label: "Delete",		  onclick: () => active.openModal('delete'), theme: "danger" }
				]}
			/>

			<Container size="4xl">


				<!-- Details -->

				<Section id="details" class="pb-12">
					<Stack>
						<Heading is="h2" as="h4" class="mb-6">Project Settings</Heading>
						<p>
							These settings apply to the entire <strong class="font-semibold">{active.name}</strong> project, but will not apply to other projects.
							<br />
							To edit settings for the entire application, go to your <Link href={route('user.settings')}>user settings</Link>.
						</p>
						<p>Rename this project</p>
						<p>Update project description</p>
					</Stack>
					<!-- <ProjectForm project={activeProject} /> -->
				</Section>


				<!-- Settings -->

				<Section id="settings" class="pb-12">
					<!-- <Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h6">Settings</Heading>
					</Flex> -->
					<Stack>
						<Heading is="h3" as="h6" class="mb-3">Settings</Heading>
						<p class="mb-3">Choose a theme for this project.</p>
						<Flex gap={6}>
							<div class="cursor-pointer bg-accent-gradient border border-accent-strong h-11 rounded-full w-11 outline outline-2 outline-offset-2 outline-emerald-500"></div>
							<div class="cursor-pointer bg-gradient-to-b from-sky-400 to-sky-600 border border-sky-700 h-11 rounded-full w-11"></div>
							<div class="cursor-pointer bg-gradient-to-b from-rose-400 to-rose-600 border border-rose-700 h-11 rounded-full w-11"></div>
							<div class="cursor-pointer bg-gradient-to-b from-violet-400 to-violet-600 border border-violet-700 h-11 rounded-full w-11"></div>
						</Flex>
					</Stack>
					<!-- <ProjectSettingsForm /> -->
				</Section>


				<!-- Media -->

				<Section id="media" class="pb-12">
					<!-- <Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h6">Media</Heading>
					</Flex> -->
					<Stack>
						<Heading is="h3" as="h6" class="mb-3">Media</Heading>
						<p>Manage the media settings for your project here.</p>
						<p class="mb-3">Maximum file size.</p>
					</Stack>
					<!-- <ProjectSettingsForm /> -->
				</Section>

				<!-- Media -->

				<Section id="custom" class="pb-12">
					<!-- <Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h5">Custom Fields</Heading>
					</Flex> -->
					<Stack>
						<Heading is="h3" as="h6" class="mb-3">Custom Fields</Heading>
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