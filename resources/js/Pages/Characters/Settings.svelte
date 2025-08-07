<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharacterSettingsForm from '@/Forms/CharacterSettingsForm.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import HeaderButton from '@/Components/HeaderButton.svelte'
	import Section from '@/Components/Section.svelte'

	const activeProject = $page.props.activeProject.data

</script>

<svelte:head>
    <title>{activeProject.name} / Character Settings</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Characters", href: route('characters') },
			{ title: "Settings" }
		]} />
		<HeaderButton icon="Plus" theme="accent" href={route('characters.create')} />
	{/snippet}

	{#snippet article()}
		<Back href={route('characters')} />
		<Section class="space-y-6"
			title="Character Settings"
			subtitle="Manage your character settings and preferences for this project."
		>
			<CharacterSettingsForm />
		</Section>
	{/snippet}

	{#snippet sidebar()}
		<CustomFieldsPanel />
	{/snippet}

</AuthenticatedLayout>