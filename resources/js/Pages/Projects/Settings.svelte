<script>
	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import ProjectSettingsForm from '@/Forms/Settings/ProjectSettings.svelte'
	import Flex   	  from '@/Components/Core/Flex.svelte'
	import Grid   	  from '@/Components/Core/Grid.svelte'
	import Stack   	  from '@/Components/Core/Stack.svelte'
	import Container   from '@/Components/UI/Container.svelte'
	import Field       from '@/Components/UI/Field.svelte'
	import Heading     from '@/Components/UI/Heading.svelte'
	import PageHeader  from '@/Components/UI/PageHeader.svelte'
	import PageHeading from '@/Components/UI/PageHeading.svelte'
	import PageMenu    from '@/Components/UI/PageMenu.svelte'
	import Section     from '@/Components/UI/Section.svelte'
	import Separator   from '@/Components/UI/Separator.svelte'

	import ProjectList 	 from '@/services/ProjectList'
	import ProjectObject from '@/services/ProjectObject'

	// const activeProject = $page.props.activeProject?.data
	let activeProject 	= $state($page.props.activeProject?.data)
	let active			= $derived( activeProject ? new ProjectObject(activeProject) : null )

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

		<Stack class="h-full w-full">
			<PageHeader size="6xl" class="flex-none px-20 py-2"
				title={ activeProject ? null : "Projects" }
				tabs={ activeProject ? [
					{ text: 'Dashboard', href: route('dashboard') },
					{ text: 'Settings',  active: true }
				] : undefined }
				actions={[
					{ icon: "X", 	text: "Deactivate",	 theme: "danger", onclick: () => active.deactivate(), 	if: !!activeProject },
					{ icon: "Plus", text: "Create Project", theme: "accent", onclick: () => projectList.create(),	if: !activeProject }
				]}
			/>
			<Flex gap={20} class="flex-1 min-h-64 overflow-y-auto px-20 py-12 w-full">
				<PageMenu items={[
					{ icon: "UserList",       label: "Overview",      href: "#overview" },
					{ icon: "GearFine",       label: "Settings",      href: "#settings" },
					{ icon: "ImagesSquare",   label: "Media",         href: "#media"    },
					{ icon: "Textbox",        label: "Custom Fields", href: "#custom"   },
					{ icon: "Trash",	 	  label: "Delete",		  onclick: () => active.openModal('delete'), theme: "danger" }
				]} />
				<Stack class="flex-1 min-w-xl">
	
					<PageHeading class="mb-12"
						title="Project Settings"
						subtitle="These settings apply to this project, but will not apply to your other projects."
					/>
	
					<!-- Overview -->
	
					<Section id="details" class="my-12">
						<Heading is="h3" as="h5" class="mb-6">Overview</Heading>
						<ProjectSettingsForm project={activeProject} />
					</Section>
					<Separator class="my-12" />
	
	
					<!-- Settings -->
	
					<Section id="settings" class="my-12">
						<Stack>
							<Heading is="h3" as="h5" class="mb-6">Settings</Heading>
							<p class="mb-3">Choose a theme for this project.</p>
							<Flex gap={6}>
								<div class="cursor-pointer bg-accent-gradient border border-accent-strong h-11 rounded-full w-11 outline outline-2 outline-offset-4 outline-emerald-500"></div>
								<div class="cursor-pointer bg-gradient-to-b from-sky-400 to-sky-600 border border-sky-700 h-11 rounded-full w-11"></div>
								<div class="cursor-pointer bg-gradient-to-b from-pink-400 to-pink-600 border border-pink-700 h-11 rounded-full w-11"></div>
								<div class="cursor-pointer bg-gradient-to-b from-violet-400 to-violet-600 border border-violet-700 h-11 rounded-full w-11"></div>
							</Flex>
						</Stack>
					</Section>
					<Separator class="my-12" />
	
	
					<!-- Media -->
	
					<Section id="media" class="my-12">
						<!-- <Flex align="center" class="mb-6 max-w-[32ch]">
							<Heading is="h3" as="h6">Media</Heading>
						</Flex> -->
						<Stack>
							<Heading is="h3" as="h5" class="mb-3">Media</Heading>
							<p>Manage the media settings for your project here.</p>
							<p class="mb-3">Maximum file size.</p>
						</Stack>
						<!-- <ProjectSettingsForm /> -->
					</Section>
					<Separator class="my-12" />
	
	
					<!-- Custom Fields -->
	
					<Section id="custom" class="my-12">
						<!-- <Flex align="center" class="mb-6 max-w-[32ch]">
							<Heading is="h3" as="h5">Custom Fields</Heading>
						</Flex> -->
						<Stack>
							<Heading is="h3" as="h5" class="mb-3">Custom Fields</Heading>
							<p>Manage the custom fields for this project.</p>
						</Stack>
						<!-- <ProjectSettingsForm /> -->
					</Section>
					<Separator class="my-12" />
	
				</Stack>
			</Flex>
		</Stack>
	{/snippet}
</AuthenticatedLayout>