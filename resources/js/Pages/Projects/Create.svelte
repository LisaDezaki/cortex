<script>
    import UserLayout from '@/Layouts/UserLayout.svelte'
	import CreateProjectForm from './Partials/CreateProjectForm.svelte'

	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
</script>

<svelte:head>
    <title>New Project</title>
</svelte:head>

<UserLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "User", href: "/user" },
			{ title: "Projects", href: "/user/projects"},
			{ title: "New project" }
		]} />
	{/snippet}

	<section class="p-12">
		<header class="mb-6">
			<h2 class="font-style-h4">New Project</h2>
			<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
				Create a brand new world and populate it with all your great ideas!
			</p>
		</header>

		<CreateProjectForm />

	</section>
    
</UserLayout>