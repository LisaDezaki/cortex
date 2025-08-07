<!-- <script>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import ProjectForm from '@/Forms/ProjectForm.svelte'

	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
    import { route } from 'momentum-trail'
</script>

<svelte:head>
    <title>New Project</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Projects", href: route('projects') },
			{ title: "New project" }
		]} />
	{/snippet}

	{#snippet article()}
		<Heading
			heading="New Project"
			subheading="Create a brand new world and populate it with all your great ideas!"
		/>
		<ProjectForm />
	{/snippet}
    
</AuthenticatedLayout> -->