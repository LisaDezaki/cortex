<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionsPanel from '@/Partials/FactionsPanel.svelte'
	import FactionForm from '@/Forms/Faction/Faction.svelte'

	import Back       from '@/Components/UI/Back.svelte';
	import Container  from '@/Components/UI/Container.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'

	const activeProject = $page.props.activeProject

</script>





<svelte:head>
    <title>New Faction</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
				{ label: "Factions",   href: route('factions') },
				{ label: "Create" }
			]}
			back={route('factions')}
			title="Create Faction"
		/>
	{/snippet}
	
	<!-- {#snippet panel()}
		<FactionsPanel />
	{/snippet} -->

	{#snippet article()}
		<Container size="7xl" class="flex gap-12">
			<PageMenu
				class="sticky top-6 left-6"
				items={[
					{ icon: "Info",         label: "Details",       href: "#details",      active: $page.url.endsWith('#details') },
					{ icon: "MapPinArea",   label: "Headquarters",  href: "#hq",           active: $page.url.endsWith('#hq') },
					{ icon: "UsersFour",    label: "Membership",    href: "#membership",   active: $page.url.endsWith('#membership') },
					{ icon: "ImagesSquare", label: "Media",         href: "#media",        active: $page.url.endsWith('#media') },
					{ icon: "Textbox",      label: "Custom Fields", href: "#customfields", active: $page.url.endsWith('#customfields') }
				]}
			/>
			<FactionForm />
		</Container>
	{/snippet}

	<!-- {#snippet sidebar()}
		Empty
	{/snippet} -->

</AuthenticatedLayout>