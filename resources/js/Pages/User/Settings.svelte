<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Form from '@/Components/Form'
	import Heading from '@/Components/Heading.svelte';
	import Panel from '@/Components/Panel';
	import Section from '@/Components/Section.svelte';
</script>

<svelte:head>
    <title>Settings</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet panel()}
		<Panel>
			<Panel.Item icon="UserList"   label="Profile"       href={route('profile.edit')} active={$page.url.startsWith('/user/profile')} />
			<Panel.Item icon="GlobeStand" label="Projects"      href={route('projects')}     active={$page.url.startsWith('/user/projects')} />
			<Panel.Item icon="GearFine"   label="Settings"      href={route('settings')}     active={$page.url.startsWith('/user/settings')} />
			<Panel.Item icon="SignOut"    label="Log Out"       href={route('logout')}       as="button" method="post" class="text-rose-500" />
		</Panel>
	{/snippet}
	
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "User", href: "/user" },
			{ title: "Settings" }
		]} />
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