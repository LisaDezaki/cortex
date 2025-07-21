<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionsPanel from '@/Partials/FactionsPanel.svelte'
	import FactionForm from '@/Forms/FactionForm.svelte'
	import DeleteFactionForm from '@/Forms/DeleteFactionForm.svelte'

	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import Modal from '@/Components/Modal.svelte'

	let project = $page.props.active_project.data
	let faction = $page.props.faction.data

	let deletingFaction = $state(false)

	function deleteFaction() {
        deletingFaction = true
    }
	function closeModal() {
		deletingFaction = false
    }

</script>

<svelte:head>
    <title>{project.name} / {faction.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",    href: "/" },
			{ title: "Factions",   href: route('factions') },
			{ title: faction.name, href: route('factions.show', {faction: faction.slug}) },
			{ title: "Edit" }
		]} />
		<Button style="plain" theme="danger" class="border-l"
			icon="Trash" iconSize={24}
			onclick={deleteFaction}
		/>
	{/snippet}

	{#snippet panel()}
		<FactionsPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('factions.show', {faction: faction.slug})} />
		<FactionForm {faction} />
	{/snippet}
	
</AuthenticatedLayout>

<Modal show={deletingFaction} onclose={closeModal}>
	<DeleteFactionForm {faction} oncancel={closeModal} />
</Modal>