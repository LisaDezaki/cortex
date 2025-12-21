<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

	import AuthenticatedLayout 			from '@/Layouts/AuthenticatedLayout.svelte'
    import UpdatePasswordForm           from '@/Forms/User/UpdatePassword.svelte'
    import UpdateProfileInformationForm from '@/Forms/User/UpdateProfile.svelte'
	import Flex 	from '@/Components/Core/Flex.svelte'
	import Stack	from '@/Components/Core/Stack.svelte'
	import Button      from '@/Components/UI/Button.svelte'
	import Container   from '@/Components/UI/Container.svelte'
	import Heading     from '@/Components/UI/Heading.svelte'
	import Media from '@/Components/UI/Media.svelte'
	import PageHeader  from '@/Components/UI/PageHeader.svelte'
	import PageMenu    from '@/Components/UI/PageMenu.svelte'
	import Section     from '@/Components/UI/Section.svelte'


	//	Page & Component props

    import UserObject from '@/services/UserObject';
	const user = new UserObject($page.props.auth.user.data)

	let { mustVerifyEmail, status } = $props()

</script>



<svelte:head>
    <title>Edit Profile</title>
</svelte:head>

<AuthenticatedLayout>

    {#snippet header()}
		<PageHeader
			tabs={[
				{ text: "Profile",		active: true },
				{ text: "Settings",	href: route('user.settings') },
			]}
		/>
	{/snippet}

    {#snippet article()}
		<Flex justify="center" class="py-12">
			<Media
				class="relative aspect-square bg-neutral-softest rounded-full w-48"
				media={user.getMedia('avatar')}
				onclick={() => user.openModal('setAvatar')}
			/>
		</Flex>
		<Flex justify="center" gap={12} class="py-12">
			<PageMenu items={[
				{ icon: "UserList", label: "Profile Info",    href: "#profile",  active: $page.url.endsWith('#profile') },
				{ icon: "Password", label: "Update Password", href: "#password", active: $page.url.endsWith('#password') },
				{ icon: "Trash",    label: "Delete Account",  onclick: () => user.openModal('delete'), theme: "danger" }
			]} />

			<Container gap={12} size="2xl">

				<Section id="profile" class="max-w-[64ch]">
					<Stack gap={1.5}>
						<Heading is="h1" as="h5">Profile Information</Heading>
						<p>Update your account's profile information and email address.</p>
					</Stack>
					<UpdateProfileInformationForm {mustVerifyEmail} {status} />
				</Section>

				<Section id="password" class="max-w-[64ch]">
					<Stack gap={1.5}>
						<Heading is="h3" as="h5">Update Password</Heading>
						<p>Ensure your account is using a long, random password to stay secure.</p>
					</Stack>
					<UpdatePasswordForm />
				</Section>

			</Container>
		</Flex>
    {/snippet}
</AuthenticatedLayout>