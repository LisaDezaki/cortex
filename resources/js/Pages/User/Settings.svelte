<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Form from '@/Components/Form.svelte'
	import Heading from '@/Components/Heading.svelte';
	import Panel from '@/Components/Panel';
	import Section from '@/Components/Section.svelte';
</script>

<svelte:head>
    <title>Settings</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet header()}
		<Breadcrumbs data={[ { title: "Settings" } ]} />
    {/snippet}

	{#snippet article()}
		<Section>
			<Heading is="h1" as="h5" class="mb-9"
				heading="App Settings"
				subheading="Adjust your account settings to align with your preferences."
			/>
			<Form submitLabel="Update settings">
				<Form.Field>
					<Form.Switch id="username" label="Enable or disabled some feature or whatever." />
					<Form.Error for="username" />
				</Form.Field>
				<Form.Field>
					<Form.Switch id="username" label="Enable or disabled some feature or whatever." />
					<Form.Error for="username" />
				</Form.Field>
				<Form.Field>
					<Form.Switch id="username" label="Enable or disabled some feature or whatever." />
					<Form.Error for="username" />
				</Form.Field>
				<Form.Field>
					<Form.Switch id="username" label="Enable or disabled some feature or whatever." />
					<Form.Error for="username" />
				</Form.Field>
				<Form.Field>
					<Form.Switch id="username" label="Enable or disabled some feature or whatever." />
					<Form.Error for="username" />
				</Form.Field>
			</Form>
		</Section>
	{/snippet}

</AuthenticatedLayout>