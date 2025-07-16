<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
    import CustomFieldForm from '@/Forms/CustomFieldForm.svelte'
	import Article from '@/Components/Article.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Form from '@/Components/Form'
	import Modal from '@/Components/Modal.svelte'
	import Sidebar from '@/Components/Sidebar.svelte'

	let project = $page.props.active_project.data

	let showCustomFieldForm = $state(false)

	function openModal() {
        showCustomFieldForm = true
    }
	function closeModal() {
		showCustomFieldForm = false
    }

</script>

<svelte:head>
    <title>{project.name} / Character Settings</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",      href: "/" },
			{ title: "Characters",   href: route('characters') },
			{ title: "Settings" }
		]} />
	{/snippet}

	<Article
		title="Character Settings"
		subtitle="Manage your character settings and preferences for this project."
		class="w-full px-20 py-12 overflow-y-auto"
		bodyclass="space-y-6"
	>
		<Form>
			<Form.Field
				type="switch"
				label="Enable Character Subtitles"
			/>
		</Form>
	</Article>

	<Sidebar>
		<CustomFieldsPanel />
	</Sidebar>

	<Modal show={showCustomFieldForm} onclose={closeModal}>
		<CustomFieldForm oncancel={closeModal} />
	</Modal>

</AuthenticatedLayout>