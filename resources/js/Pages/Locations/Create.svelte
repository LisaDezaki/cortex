<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import LocationsPanel from '@/Partials/LocationsPanel.svelte'
	import LocationForm from '@/Forms/Location/Location.svelte'
	import Back from '@/Components/UI/Back.svelte'

	const activeProject = $page.props.activeProject.data

</script>





<svelte:head>
    <title>{activeProject.name} / New Location</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet panel()}
		<LocationsPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('locations')} />
		<LocationForm />
	{/snippet}

	{#snippet sidebar()}
		Empty
	{/snippet}

</AuthenticatedLayout>