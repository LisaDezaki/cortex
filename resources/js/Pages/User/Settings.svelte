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
			tabs={[
				{ label: "Profile",		href: route('user.edit') },
				{ label: "Settings",	active: true },
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
						<Heading is="h1" as="h5">Account Settings</Heading>
						<p>Adjust your account settings to align with your preferences.</p>
					</Stack>
					<Form
						class="max-w-lg"
						enctype="multipart/form-data"
						endpoint={route('user.settings')}
						form={form}
						method="post"
						processing={$form.processing}
						recentlySuccessful={$form.recentlySuccessful}
						onFinish={oncancel}
					>
						<ul>
							<li>Set theme colors</li>
							<li>Light/dark preferences</li>
							<li></li>
						</ul>
					</Form>
				</Section>

			</Container>
		</Flex>
	{/snippet}

</AuthenticatedLayout>