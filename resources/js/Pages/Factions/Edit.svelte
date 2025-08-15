<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionsPanel from '@/Partials/FactionsPanel.svelte'

	import FactionForm from '@/Forms/Faction/Faction.svelte'
	import DeleteFactionForm from '@/Forms/Faction/Delete.svelte'

	import Back  from '@/Components/UI/Back.svelte'
	import Container  from '@/Components/UI/Container.svelte'
	import Modal from '@/Components/UI/Modal.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'

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
    <title>Edit {faction.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
				{ label: "Factions",   href: route('factions') },
				{ label: faction.name, href: route('factions.show', { faction: faction.slug }) },
				{ label: "Edit" }
			]}
			back={route('factions.show', {faction: faction.slug})}
			title="Edit Faction"
			actions={[
				{ icon: "Trash", onclick: deleteFaction, theme: "danger" }
			]}
		/>
	{/snippet}

	{#snippet article()}
		<Container size="7xl" class="flex gap-12">
			<PageMenu
				class="sticky top-6 left-6"
				items={[
					{ icon: "Info",      label: "Details",    href: "#details",    active: $page.url.endsWith('#details') },
					{ icon: "MapPinArea", label: "Headquarters", href: "#hq", active: $page.url.endsWith('#hq') },
					{ icon: "UsersFour", label: "Membership", href: "#membership", active: $page.url.endsWith('#membership') },
					{ icon: "ImagesSquare",   label: "Media",         href: "#media",         active: $page.url.endsWith('#media') },
					{ icon: "Textbox",        label: "Custom Fields", href: "#customfields",  active: $page.url.endsWith('#customfields') }
				]}
			/>
			<FactionForm {faction} class="py-12" />
		</Container>
	{/snippet}

	<!-- {#snippet sidebar()}
		Empty
	{/snippet} -->
	
</AuthenticatedLayout>

<Modal show={deletingFaction} onclose={closeModal}>
	<DeleteFactionForm {faction} oncancel={closeModal} />
</Modal>