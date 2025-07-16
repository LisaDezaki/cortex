<script>
	import { page } from '@inertiajs/svelte'

    import LocationsLayout from '@/Layouts/LocationsLayout.svelte'
	import LocationForm from './Partials/LocationForm.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';

	let project = $page.props.active_project

</script>

<svelte:head>
    <title>{project.name} / New Location</title>
</svelte:head>

<LocationsLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",    href: "/" },
			{ title: "Locations", href: "/locations" },
			{ title: "Create" }
		]} />
	{/snippet}

	<section class="p-12 space-y-12">
		<LocationForm />
	</section>

</LocationsLayout>