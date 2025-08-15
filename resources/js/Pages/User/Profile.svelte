<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import AuthenticatedLayout          from '@/Layouts/AuthenticatedLayout.svelte'
	
    import DeleteUserForm               from '@/Forms/User/Delete.svelte'
    import UpdatePasswordForm           from '@/Forms/User/UpdatePassword.svelte'
    import UpdateProfileInformationForm from '@/Forms/User/UpdateProfile.svelte'

	import { Stack } from '@/Components/Core'

	import Breadcrumbs from '@/Components/UI/Breadcrumbs.svelte'
	import Button      from '@/Components/UI/Button.svelte'
	import Container   from '@/Components/UI/Container.svelte'
	import Heading     from '@/Components/UI/Heading.svelte'
	import Modal       from '@/Components/UI/Modal.svelte'
	import PageHeader  from '@/Components/UI/PageHeader.svelte'
	import PageMenu    from '@/Components/UI/PageMenu.svelte'
	import Section     from '@/Components/UI/Section.svelte'

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
		<PageHeader
			breadcrumbs={[
				{ label: "Profile" }
			]}
			back={route('dashboard')}
			title="Account Profile"
		/>
	{/snippet}

    {#snippet article()}

		<Container size="7xl" class="flex gap-12">
			<PageMenu
				items={[
					{ icon: "UserList", label: "Profile Info",    href: "#profile",  active: $page.url.endsWith('#profile') },
					{ icon: "Password", label: "Update Password", href: "#password", active: $page.url.endsWith('#password') },
					{ icon: "Trash",    label: "Delete Account",  onclick: confirmUserDeletion, theme: "danger" }
				]}
			/>
			<Stack class="py-12">
				<Section>
					<Heading is="h4" as="h6"
						heading="Profile Information"
						subheading="Update your account's profile information and email address."
					/>
					<UpdateProfileInformationForm {mustVerifyEmail} {status} />
				</Section>
				<Section>
					<Heading is="h4" as="h6"
						heading="Update Password"
						subheading="Ensure your account is using a long, random password to stay secure."
					/>
					<UpdatePasswordForm />
				</Section>
				<Section>
					<Heading is="h4" as="h6"
						heading="Delete Account"
						subheading="Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
					your account, please download any data or information that you wish to retain."
					/>
					<Button style="hard" theme="danger"
						label="Delete Account"
						onclick={confirmUserDeletion}
					/>
				</Section>
			</Stack>
		</Container>

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
		
    {/snippet}

</AuthenticatedLayout>

<Modal show={confirmingUserDeletion} onclose={closeModal}>
	<DeleteUserForm oncancel={closeModal} />
</Modal>