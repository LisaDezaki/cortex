<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
	import Form       from '@/Components/Core/Form.svelte'
	import Back       from '@/Components/UI/Back.svelte'
	import Container  from '@/Components/UI/Container.svelte'
	import Heading    from '@/Components/UI/Heading.svelte'
	import Field      from '@/Components/UI/Field.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'
	import Section    from '@/Components/UI/Section.svelte'

	const activeProject = $page.props.activeProject.data
	const settings = $page.props.settings?.factions?.data

	const form = useForm({
        enable_factions: ''
    })

	function updateSettings() {
		console.log('update settings');
	}

</script>

<svelte:head>
    <title>Faction Settings</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
				{ label: "Factions",   href: route('factions') },
				{ label: "Settings" }
			]}
			back={route('factions')}
			title="Faction Settings"
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
			<Form class="py-12">
				<Field layout="block"
					type="switch"
					label="Enable Factions"
					description="Enable factions for this project?"
					bind:value={$form.enable_factions}
				/>
			</Form>
		</Container>
	{/snippet}

	<!-- {#snippet sidebar()}
		<CustomFieldsPanel />
	{/snippet} -->

</AuthenticatedLayout>