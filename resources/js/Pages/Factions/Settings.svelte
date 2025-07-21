<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
	import Back from '@/Components/Back.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Form from '@/Components/Form'
	import Section from '@/Components/Section.svelte'

	let project = $page.props.active_project.data

</script>

<svelte:head>
    <title>{project.name} / Faction Settings</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",  href: "/" },
			{ title: "Factions", href: route('factions') },
			{ title: "Settings" }
		]} />
		<Button style="plain" theme="accent" class="border-l"
			icon="Plus" iconSize={24} iconWeight="light"
			href={route('factions.create')}
		/>
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