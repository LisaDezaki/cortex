<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharactersPanel from '@/Partials/CharactersPanel.svelte'
	import CharacterForm from '@/Forms/Character/Character.svelte'

	import Back       from '@/Components/UI/Back.svelte'
	import Container  from '@/Components/UI/Container.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'

	const activeProject = $page.props.activeProject.data

</script>





<svelte:head>
    <title>New Character</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
				{ label: "Characters",   href: route('characters') },
			]}
			back={route('characters')}
			title="Create Character"
		/>
	{/snippet}
	
	<!-- {#snippet panel()}
		<CharactersPanel />
	{/snippet} -->

	{#snippet article()}
		<Container size="7xl" class="flex gap-12">
			<PageMenu
				class="sticky top-6 left-6"
				items={[
					{ icon: "UserList",       label: "Details",       href: "#bio",           active: $page.url.endsWith('#bio') },
					{ icon: "Handshake",      label: "Relationships", href: "#relationships", active: $page.url.endsWith('#relationships') },
					{ icon: "FlagBannerFold", label: "Factions",      href: "#factions",      active: $page.url.endsWith('#factions') },
					{ icon: "Backpack",       label: "Inventory",     href: "#inventory",     active: $page.url.endsWith('#inventory') },
					{ icon: "ImagesSquare",   label: "Media",         href: "#media",         active: $page.url.endsWith('#media') },
					{ icon: "Textbox",        label: "Custom Fields", href: "#customfields",  active: $page.url.endsWith('#customfields') }
				]}
			/>
			<CharacterForm class="py-6" />
		</Container>
	{/snippet}

	<!-- {#snippet sidebar()}
		Empty
	{/snippet} -->

</AuthenticatedLayout>