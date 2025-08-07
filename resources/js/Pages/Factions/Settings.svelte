<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
	import Back from '@/Components/Back.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Form from '@/Components/Form.svelte'
	import HeaderButton from '@/Components/HeaderButton.svelte';
	import Section from '@/Components/Section.svelte'

	const activeProject = $page.props.activeProject.data

</script>

<svelte:head>
    <title>{activeProject.name} / Faction Settings</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Factions",   href: route('factions') },
			{ title: "Settings" }
		]} />
		<HeaderButton icon="Plus" theme="accent" href={route('factions.create')} />
	{/snippet}

	{#snippet article()}
		<Back href={route('factions')} />
		<Section
			title="Faction Settings"
			subtitle="Manage your faction settings and preferences for this project."
		>
			<Form>
				<Form.Field
					type="switch"
					label="Enable Factions"
				/>
			</Form>
		</Section>
	{/snippet}

	{#snippet sidebar()}
		<CustomFieldsPanel />
	{/snippet}

</AuthenticatedLayout>