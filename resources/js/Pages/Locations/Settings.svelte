<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
	import Article from '@/Components/Article.svelte';
	import Back from '@/Components/Back.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Form from '@/Components/Form.svelte'
	import Heading from '@/Components/Heading.svelte';
	import Section from '@/Components/Section.svelte'

	const activeProject = $page.props.activeProject.data

</script>

<svelte:head>
    <title>{activeProject.name} / Location Settings</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Locations",  href: route('locations') },
			{ title: "Settings" }
		]} />
	{/snippet}

	{#snippet article()}
		<Back href={route('locations')} />

		<Section>
			<Heading is="h2" as="h4"
				heading="Location Settings"
				subheading="Manage your location settings and preferences for this project."
			/>
			<Form>
				<Form.Field
					type="switch"
					label="Enable Regions"
				/>
			</Form>
		</Section>
	{/snippet}

	{#snippet sidebar()}
		<CustomFieldsPanel />
	{/snippet}

</AuthenticatedLayout>