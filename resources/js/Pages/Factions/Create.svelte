<script>
	import { page } from '@inertiajs/svelte'

    import FactionsLayout from '@/Layouts/FactionsLayout.svelte'
	import FactionForm from './Partials/FactionForm.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';

	let project = $page.props.active_project

</script>

<svelte:head>
    <title>{project.name} / New Faction</title>
</svelte:head>

<FactionsLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",    href: "/" },
			{ title: "Factions", href: "/factions" },
			{ title: "Create" }
		]} />
	{/snippet}

	<section class="grid grid-cols-5 gap-12 px-12 py-6">
		<FactionForm />
	</section>

</FactionsLayout>