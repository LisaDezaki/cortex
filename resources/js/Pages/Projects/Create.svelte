<script>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CreateProjectForm from '@/Forms/CreateProjectForm.svelte'

	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
</script>

<svelte:head>
    <title>New Project</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "User", href: "/user" },
			{ title: "Projects", href: "/user/projects"},
			{ title: "New project" }
		]} />
	{/snippet}

	{#snippet article()}
		<Heading
			heading="New Project"
			subheading="Create a brand new world and populate it with all your great ideas!"
		/>
		<CreateProjectForm />
	{/snippet}
    
</AuthenticatedLayout>