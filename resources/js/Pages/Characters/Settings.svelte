<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharacterSettingsForm from '@/Forms/Character/Settings.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
	import Back       from '@/Components/UI/Back.svelte'
	import Container  from '@/Components/UI/Container.svelte'
	import Heading    from '@/Components/UI/Heading.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'
	import Section    from '@/Components/UI/Section.svelte'

	const activeProject = $page.props.activeProject.data
	const settings = $page.props.settings?.characters?.data

</script>

<svelte:head>
    <title>Character Settings</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
				{ label: "Characters",   href: route('characters') },
			]}
			back={route('characters')}
			title="Character Settings"
		/>
	{/snippet}

	{#snippet article()}
		<Container size="7xl" class="flex gap-12">
			<PageMenu
				items={[
					{ icon: "UserList",       label: "Overview",      href: "#overview",      active: $page.url.endsWith('#overview') },
					{ icon: "ImagesSquare",   label: "Media",         href: "#media",         active: $page.url.endsWith('#media') },
					{ icon: "Textbox",        label: "Custom Fields", href: "#customfields",  active: $page.url.endsWith('#customfields') }
				]}
			/>
			<CharacterSettingsForm class="py-12" />
		</Container>
	{/snippet}

	{#snippet sidebar()}
		<CustomFieldsPanel />
	{/snippet}

</AuthenticatedLayout>