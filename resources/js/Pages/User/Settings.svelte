<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Form    from '@/Components/Core/Form.svelte'
	import Field   from '@/Components/UI/Field.svelte';
	import Heading from '@/Components/UI/Heading.svelte';
	import Input   from '@/Components/UI/Input.svelte';
	import Section from '@/Components/UI/Section.svelte';
</script>

<svelte:head>
    <title>Settings</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet article()}
		<Section>
			<Heading is="h1" as="h5" class="mb-9"
				heading="App Settings"
				subheading="Adjust your account settings to align with your preferences."
			/>
			<Form submitLabel="Update settings">
				<Field>
					<Input type="switch" id="username" label="Enable or disabled some feature or whatever." />
					<Error for="username" />
				</Field>
				<Field>
					<Input type="switch" id="username" label="Enable or disabled some feature or whatever." />
					<Error for="username" />
				</Field>
				<Field>
					<Input type="switch" id="username" label="Enable or disabled some feature or whatever." />
					<Error for="username" />
				</Field>
				<Field>
					<Input type="switch" id="username" label="Enable or disabled some feature or whatever." />
					<Error for="username" />
				</Field>
				<Field>
					<Input type="switch" id="username" label="Enable or disabled some feature or whatever." />
					<Error for="username" />
				</Field>
			</Form>
		</Section>
	{/snippet}

</AuthenticatedLayout>