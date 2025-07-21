<script>
	
	import { page } from '@inertiajs/svelte'
    import UserLayout from '@/Layouts/UserLayout.svelte'
	import UpdateProjectForm from '@/Forms/UpdateProjectForm.svelte'

	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';

	let { project } = $props()

</script>

<svelte:head>
    <title>Project</title>
</svelte:head>

<UserLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "User", href: "/user" },
			{ title: "Projects", href: "/user/projects"},
			{ title: project.name }
		]} />
	{/snippet}

	<section class="p-12">
		<header class="mb-6">
			<h2 class="font-style-h4">Project Details</h2>
			<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
				Update this world's overview information here.
			</p>
		</header>

		<UpdateProjectForm project={project} />

	</section>
    
</UserLayout>