<script>
	import { page } from '@inertiajs/svelte'

	import AuthenticatedLayout          from '@/Layouts/AuthenticatedLayout.svelte'
	
    import DeleteUserForm               from '@/Forms/User/Delete.svelte'
    import UpdatePasswordForm           from '@/Forms/User/UpdatePassword.svelte'
    import UpdateProfileInformationForm from '@/Forms/User/UpdateProfile.svelte'

	import Breadcrumbs from '@/Components/UI/Breadcrumbs.svelte';
	import Button      from '@/Components/UI/Button.svelte';
	import Modal       from '@/Components/UI/Modal.svelte';
	import Section     from '@/Components/UI/Section.svelte';

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

	const user = $page.props.auth.user.data
</script>

<svelte:head>
    <title>Edit Profile</title>
</svelte:head>

<AuthenticatedLayout>

    {#snippet header()}
		<Breadcrumbs data={[ { title: "Profile"} ]} />
	{/snippet}

    {#snippet article()}

		<!-- <Section class="flex items-center gap-12 border-b">
			<SetAvatar
				id="name"
				type="text"
				src={user?.avatar?.url}
				required
				autofocus
				autocomplete="name"
			/>
			<Heading is="h2" as="h3"
				heading={user.name}
				subheading={user.email}
			/>
		</Section> -->
		<Section limitWidth class="border-b"
			title="Profile Information"
			subtitle="Update your account's profile information and email address."
		>
			<UpdateProfileInformationForm {mustVerifyEmail} {status} />
		</Section>
		<Section limitWidth class="border-b"
			title="Update Password"
			subtitle="Ensure your account is using a long, random password to stay secure."
		>
			<UpdatePasswordForm />
		</Section>
		<Section limitWidth
			title="Delete Account"
			subtitle="Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
			your account, please download any data or information that you wish to retain."
		>
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