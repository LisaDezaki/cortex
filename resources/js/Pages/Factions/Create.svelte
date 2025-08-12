<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionsPanel from '@/Partials/FactionsPanel.svelte'
	import FactionForm from '@/Forms/Faction/Faction.svelte'
	import Back from '@/Components/UI/Back.svelte';

	const activeProject = $page.props.activeProject

</script>





<svelte:head>
    <title>{activeProject.name} / New Faction</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet panel()}
		<FactionsPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('factions')} />
		<FactionForm />
	{/snippet}

	{#snippet sidebar()}
		Empty
	{/snippet}

</AuthenticatedLayout>