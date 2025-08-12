<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
	import Form    from '@/Components/Core/Form.svelte'
	import Back    from '@/Components/UI/Back.svelte';
	import Field   from '@/Components/UI/Field.svelte'
	import Heading from '@/Components/UI/Heading.svelte'
	import Section from '@/Components/UI/Section.svelte'

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

	{#snippet article()}
		<Back href={route('factions')} />
		<Section>
			<Heading is="h2" as="h4" class="mb-12"
				heading="Faction Settings"
				subheading="Manage your faction settings and preferences for this project."
			/>
			<Form>
				<Field layout="block"
					type="switch"
					label="Enable Factions"
					description="Enable factions for this project?"
					bind:value={$form.enable_factions}
				/>
			</Form>
		</Section>
	{/snippet}

	{#snippet sidebar()}
		<CustomFieldsPanel />
	{/snippet}

</AuthenticatedLayout>