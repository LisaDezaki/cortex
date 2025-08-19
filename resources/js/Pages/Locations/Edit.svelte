<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import LocationForm       from '@/Forms/Location/Location.svelte'
	import DeleteLocationForm from '@/Forms/Location/Delete.svelte'

	import Container  from '@/Components/UI/Container.svelte'
	import Modal      from '@/Components/UI/Modal.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'

	const location = $page.props.location.data

	let deletingLocation = $state(false)

	function deleteLocation() {
        deletingLocation = true
    }
	function closeModal() {
		deletingLocation = false
    }

</script>





<svelte:head>
    <title>Edit {location.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
				{ label: "Locations",   href: route('locations') },
				{ label: location.name, href: route('locations.show', { location: location.slug }) },
			]}
			back={route('locations.show', { location: location.slug })}
			title="Edit Location"
			actions={[
				{ icon: "Trash", onclick: deleteLocation, theme: "danger" }
			]}
		/>
	{/snippet}

	{#snippet article()}
		<Container size="7xl" class="flex gap-12">
			<LocationForm {location} class="overflow-y-auto py-12"/>
		</Container>
	{/snippet}

</AuthenticatedLayout>

<Modal show={deletingLocation} onclose={closeModal}>
	<DeleteLocationForm {location} oncancel={closeModal} />
</Modal>