<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
    import DeleteUserForm from '@/Forms/DeleteUserForm.svelte'
    import UpdatePasswordForm from '@/Forms/UpdatePasswordForm.svelte'
    import UpdateProfileInformationForm from '@/Forms/UpdateProfileInformationForm.svelte'
	import Avatar from '@/Components/Avatar.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Heading from '@/Components/Heading.svelte';
	import Modal from '@/Components/Modal.svelte';
	import Panel from '@/Components/Panel';
	import Section from '@/Components/Section.svelte';

	let confirmingUserDeletion = $state(false)

	function closeModal() {
        confirmingUserDeletion = false
    }

    function confirmUserDeletion() {
        confirmingUserDeletion = true
    }

    let {
        mustVerifyEmail,
        status,
    } = $props()

	const user = $page.props.auth.user
</script>

<svelte:head>
    <title>Profile</title>
</svelte:head>

<AuthenticatedLayout>

    {#snippet header()}
		<Breadcrumbs data={[
			{ title: "User", href: "/user" },
			{ title: "Profile"}
		]} />
	{/snippet}

	{#snippet panel()}
		<Panel>
			<Panel.Item icon="UserList"   label="Profile"       href={route('profile.edit')} active={$page.url.startsWith('/user/profile')} />
			<Panel.Item icon="GlobeStand" label="Projects"      href={route('projects')}     active={$page.url.startsWith('/user/projects')} />
			<Panel.Item icon="GearFine"   label="Settings"      href={route('settings')}     active={$page.url.startsWith('/user/settings')} />
			<Panel.Item icon="SignOut"    label="Log Out"       href={route('logout')}       as="button" method="post" class="text-rose-500" />
		</Panel>
	{/snippet}

    {#snippet article()}
		<Section>
			<Avatar class="w-32" src={user.avatar} fallback="AV" />
		</Section>
		<Section
			title="Profile Information"
			subtitle="Update your account's profile information and email address."
		>
			<!-- <Heading
				heading="Profile Information"
				subheading="Update your account's profile information and email address."
			/> -->
			<UpdateProfileInformationForm {mustVerifyEmail} {status} />
		</Section>
		<Section
			title="Update Password"
			subtitle="Ensure your account is using a long, random password to stay secure."
		>
			<!-- <Heading
				heading="Update Password"
				subheading="Ensure your account is using a long, random password to stay secure."
			/> -->
			<UpdatePasswordForm />
		</Section>
		<Section
			title="Delete Account"
			subtitle="Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
			your account, please download any data or information that you wish to retain."
		>
			<!-- <Heading
				heading="Delete Account"
				subheading="Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
			your account, please download any data or information that you wish to retain."
			/> -->
			<Button style="hard" theme="danger"
				label="Delete Account"
				onclick={confirmUserDeletion}
			/>
		</Section>
    {/snippet}

</AuthenticatedLayout>

<Modal show={confirmingUserDeletion} onclose={closeModal}>
	<DeleteUserForm oncancel={closeModal} />
</Modal>