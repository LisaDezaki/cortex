<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
	import UploadContext from '@/Components/Util/UploadContext.svelte';
	import UploadPreview from '@/Components/Util/UploadPreview.svelte';
	import UploadTrigger from '@/Components/Util/UploadTrigger.svelte';
	import Back from '@/Components/Back.svelte';
	import Button from '@/Components/Button.svelte';
	import Field from '@/Components/Field.svelte'
	import Form from '@/Components/Form.svelte'
	import Heading from '@/Components/Heading.svelte';
	import Section from '@/Components/Section.svelte'

	const activeProject = $page.props.activeProject.data
	const settings = $page.props.settings?.factions?.data

	const form = useForm({
        enable_regions: ''
    })

	function updateSettings() {
		console.log('update settings');
	}

</script>

<svelte:head>
    <title>Location Settings</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet article()}
		<Back href={route('locations')} />

		<Section>
			<Heading is="h2" as="h4" class="mb-12"
				heading="Location Settings"
				subheading="Manage your location settings and preferences for this project."
			/>
			<Form>
				<Field layout="block"
					type="switch"
					label="Enable Regions"
					description="Enable regions for this project?"
					bind:value={$form.enable_regions}
				/>
			</Form>
		</Section>
	{/snippet}

	{#snippet sidebar()}
		<CustomFieldsPanel />
	{/snippet}

</AuthenticatedLayout>