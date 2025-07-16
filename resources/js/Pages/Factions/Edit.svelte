<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import FactionsLayout from '@/Layouts/FactionsLayout.svelte'
	import FactionForm from './Partials/FactionForm.svelte'
	// import DeleteFactionForm from './Partials/DeleteFactionForm.svelte'
	import Article from '@/Components/Article.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Modal from '@/Components/Modal.svelte'

	let project = $page.props.active_project.data
	let faction = $page.props.faction.data

	let deletingFaction = $state(false)

	// function deleteFaction() {
    //     deletingFaction = true
    // }
	function closeModal() {
		deletingFaction = false
    }

</script>

<svelte:head>
    <title>{project.name} / {faction.name}</title>
</svelte:head>

<FactionsLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",    href: "/" },
			{ title: "Factions",   href: route('factions') },
			{ title: faction.name, href: route('factions.show', {faction: faction.slug}) },
			{ title: "Edit" }
		]} />
		<!-- <Button plain icon="Trash" iconSize={24} onclick={deleteFaction} class="border-l w-14 hover:bg-rose-500/20 hover:text-rose-500" /> -->
	{/snippet}

	<section class="grid grid-cols-5 gap-12 px-12 py-6">
		<FactionForm faction={faction} />
	</section>

	<!-- <Modal show={deletingFaction} onclose={closeModal}>
		<DeleteFactionForm {faction} oncancel={closeModal} />
	</Modal> -->

</FactionsLayout>