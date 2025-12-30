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

		<PageHeader size="7xl" class="px-20 py-2"
			back={() => active.deactivate()}
			backLabel="All Projects"
			tabs={[
				{ text: 'Dashboard', href: route('dashboard') },
				{ text: 'Settings',  active: true }
			]}
		/>

		<Flex justify="center" gap={20} class="flex-1 min-h-64 overflow-y-auto px-20 py-12 w-full">
			<PageMenu items={[
				{ icon: "UserList",       label: "Overview",      href: "#overview" },
				{ icon: "Palette",        label: "Appearance",    href: "#appearance" },
				{ icon: "ImagesSquare",   label: "Media",         href: "#media"    },
				{ icon: "Textbox",        label: "Custom Fields", href: "#custom"   },
				{ icon: "Trash",	 	  label: "Delete",		  onclick: () => active.openModal('delete'), theme: "danger" }
			]} />
			<Stack class="flex-1 min-w-2xl max-w-5xl">

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


				<!-- Appearance -->

				<Section id="appearance" class="my-12">
					<Heading is="h3" as="h5" class="mb-6">Appearance</Heading>
					<p>Set how you want the interface to look for this project.</p>
					<!-- <ProjectSettingsForm project={activeProject} /> -->
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
						<p class="my-3">- Maximum file size.</p>
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
	{/snippet}
</AuthenticatedLayout>