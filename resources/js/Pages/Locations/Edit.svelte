<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import LocationsPanel from '@/Partials/LocationsPanel.svelte'
	import DeleteLocationForm from '@/Forms/DeleteLocationForm.svelte'
	import LocationForm from '@/Forms/LocationForm.svelte'

	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import HeaderButton from '@/Components/HeaderButton.svelte'
	import Modal from '@/Components/Modal.svelte'

	const activeProject = $page.props.activeProject.data
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
    <title>{activeProject.name} / {location.name}</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Locations",   href: route('locations') },
			{ title: location.name, href: route('locations.show', {location: location.slug}) },
			{ title: "Edit" }
		]} />
		<HeaderButton icon="Trash" theme="danger" onclick={deleteLocation} />
	{/snippet}

	{#snippet panel()}
		<LocationsPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('locations.show', {location: location.slug})} />
		<LocationForm {location} />
	{/snippet}
	
</AuthenticatedLayout>

<Modal show={deletingLocation} onclose={closeModal}>
	<DeleteLocationForm {location} oncancel={closeModal} />
</Modal>