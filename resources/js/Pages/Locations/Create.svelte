<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import LocationForm from '@/Forms/LocationForm.svelte'
	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'

	let project = $page.props.active_project

</script>

<svelte:head>
    <title>{project.name} / New Location</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",    href: "/" },
			{ title: "Locations", href: "/locations" },
			{ title: "Create" }
		]} />
	{/snippet}

	{#snippet article()}
		<Back href={route('locations')} />
		<LocationForm />
	{/snippet}

</AuthenticatedLayout>