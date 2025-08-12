<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharacterSettingsForm from '@/Forms/Character/Settings.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
	import Back    from '@/Components/UI/Back.svelte'
	import Heading from '@/Components/UI/Heading.svelte';
	import Section from '@/Components/UI/Section.svelte'

	const activeProject = $page.props.activeProject.data

</script>

<svelte:head>
    <title>Character Settings</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet article()}
		<Back href={route('characters')} />
		<Section>
			<Heading is="h2" as="h4" class="mb-12"
				heading="Character Settings"
				subheading="Manage your character settings and preferences for this project."
			/>
			<CharacterSettingsForm />
		</Section>
	{/snippet}

	{#snippet sidebar()}
		<CustomFieldsPanel />
	{/snippet}

</AuthenticatedLayout>