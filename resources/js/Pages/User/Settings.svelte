<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import { Flex, Form, Stack } from '@/Components/Core'
	import Container   	from '@/Components/UI/Container.svelte';
	import Field   		from '@/Components/UI/Field.svelte';
	import Heading 		from '@/Components/UI/Heading.svelte';
	import Input   		from '@/Components/UI/Input.svelte';
	import PageHeader  	from '@/Components/UI/PageHeader.svelte'
	import PageMenu  	from '@/Components/UI/PageMenu.svelte'
	import Section 		from '@/Components/UI/Section.svelte';

	let form = useForm({})

</script>

<svelte:head>
    <title>Settings</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			title="User Settings"
			tabs={[
				{ label: "Profile",		href: route('profile.edit') },
				{ label: "Settings",		active: true },
			]}
		/>
	{/snippet}

	{#snippet article()}
		<Flex justify="center" gap={12} class="py-12">
			<PageMenu
				items={[
					{ icon: "Info",       label: "Overview",      href: "#overview" },
				]}
			/>
			<Container size="2xl">

				<Section>
					<Stack>
						<Heading is="h1" as="h5">Heading</Heading>
						<p>Adjust your account settings to align with your preferences.</p>
					</Stack>
					<Form
						class="max-w-lg"
						enctype="multipart/form-data"
						endpoint={route('settings')}
						form={form}
						method="post"
						processing={$form.processing}
						recentlySuccessful={$form.recentlySuccessful}
						onFinish={oncancel}
					>
						<!-- <Field>
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
						</Field> -->
					</Form>
				</Section>

			</Container>
		</Flex>
	{/snippet}

</AuthenticatedLayout>