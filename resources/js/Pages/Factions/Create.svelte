<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionsPanel from '@/Partials/FactionsPanel.svelte'
	import FactionForm from '@/Forms/FactionForm.svelte'

	import Back from '@/Components/Back.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';

	const activeProject = $page.props.activeProject

</script>

<svelte:head>
    <title>{activeProject.name} / New Faction</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Factions",   href: route('factions') },
			{ title: "Create" }
		]} />
	{/snippet}

	{#snippet panel()}
		<FactionsPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('factions')} />
		<FactionForm />
	{/snippet}

</AuthenticatedLayout>