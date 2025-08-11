<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionsPanel from '@/Partials/FactionsPanel.svelte'
	import FactionForm from '@/Forms/FactionForm.svelte'
	import DeleteFactionForm from '@/Forms/DeleteFactionForm.svelte'

	import Back from '@/Components/Back.svelte'
	import Modal from '@/Components/Modal.svelte'

	const activeProject = $page.props.activeProject.data
	const faction = $page.props.faction.data

	let deletingFaction = $state(false)

	function deleteFaction() {
        deletingFaction = true
    }
	function closeModal() {
		deletingFaction = false
    }

</script>





<svelte:head>
    <title>{activeProject.name} / {faction.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet panel()}
		<FactionsPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('factions.show', {faction: faction.slug})} />
		<FactionForm {faction} />
	{/snippet}

	{#snippet sidebar()}
		Empty
	{/snippet}
	
</AuthenticatedLayout>

<Modal show={deletingFaction} onclose={closeModal}>
	<DeleteFactionForm {faction} oncancel={closeModal} />
</Modal>