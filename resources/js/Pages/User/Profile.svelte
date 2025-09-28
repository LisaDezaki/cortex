<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	
    import UpdatePasswordForm           from '@/Forms/User/UpdatePassword.svelte'
    import UpdateProfileInformationForm from '@/Forms/User/UpdateProfile.svelte'

	import { Flex, Stack } from '@/Components/Core'

	import Breadcrumbs from '@/Components/UI/Breadcrumbs.svelte'
	import Button      from '@/Components/UI/Button.svelte'
	import Container   from '@/Components/UI/Container.svelte'
	import Heading     from '@/Components/UI/Heading.svelte'
	import Media from '@/Components/UI/Media.svelte'
	import Modal       from '@/Components/UI/Modal.svelte'
	import PageHeader  from '@/Components/UI/PageHeader.svelte'
	import PageMenu    from '@/Components/UI/PageMenu.svelte'
	import Section     from '@/Components/UI/Section.svelte'

	import { modalActions } from '@/stores/modalStore';
    function deleteUser(u) { modalActions.open('deleteUser', { user: u 	}) }

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
			title="User Profile"
			tabs={[
				{ label: "Profile",		active: true },
				{ label: "Settings",	href: route('settings') },
			]}
		/>
	{/snippet}

    {#snippet article()}
		<Flex justify="center" gap={12} class="py-12">
			<PageMenu items={[
				{ icon: "UserList", label: "Profile Info",    href: "#profile",  active: $page.url.endsWith('#profile') },
				{ icon: "Password", label: "Update Password", href: "#password", active: $page.url.endsWith('#password') },
				{ icon: "Trash",    label: "Delete Account",  onclick: deleteUser, theme: "danger" }
			]} />

			<Container gap={12} size="2xl">

				<Media replaceable
					aspect="aspect-square"
					class="relative bg-neutral-softest rounded-full w-48"
					endpoint={route('user.avatar.update', { user: user.id })}
					method="patch"
					media={user.avatar}
					reloadPageProps={['auth.user.avatar']}
					type="avatar"
				/>

				<Section id="profile" class="max-w-[64ch]">
					<Stack gap={1.5}>
						<Heading is="h1" as="h5">Profile Information</Heading>
						<p>Update your account's profile information and email address.</p>
					</Stack>
					<!-- <Heading is="h4" as="h6" class="mt-9 mb-6"
						heading="Profile Information"
						subheading="Update your account's profile information and email address."
					/> -->
					<UpdateProfileInformationForm {mustVerifyEmail} {status} />
				</Section>
				<Section id="password" class="max-w-[64ch]">
					<Stack gap={1.5}>
						<Heading is="h3" as="h6">Update Password</Heading>
						<p>Ensure your account is using a long, random password to stay secure.</p>
					</Stack>
					<!-- <Heading is="h4" as="h6" class="mt-9 mb-6"
						heading="Update Password"
						subheading="Ensure your account is using a long, random password to stay secure."
					/> -->
					<UpdatePasswordForm />
				</Section>
				<Section id="delete" class="max-w-[64ch]">
					<Stack gap={1.5}>
						<Heading is="h3" as="h6">Delete Account</Heading>
						<p>Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
					</Stack>
					<!-- <Heading is="h4" as="h6" class="mt-9 mb-6"
						heading="Delete Account"
						subheading="Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
					your account, please download any data or information that you wish to retain."
					/> -->
					<Button style="hard" theme="danger" class="mt-3"
						label="Delete Account"
						onclick={deleteUser}
					/>
				</Section>
			</Container>
		</Flex>

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

<!-- <Modal show={confirmingUserDeletion} onclose={closeModal}>
	<DeleteUserForm oncancel={closeModal} />
</Modal> -->