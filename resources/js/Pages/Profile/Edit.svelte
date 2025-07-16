<script>
	import UserLayout from '@/Layouts/UserLayout.svelte'
    import DeleteUserForm from './Partials/DeleteUserForm.svelte'
    import UpdatePasswordForm from './Partials/UpdatePasswordForm.svelte'
    import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.svelte'
	import Article from '@/Components/Article.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';

    let {
        mustVerifyEmail,
        status,
    } = $props()
</script>

<svelte:head>
    <title>Profile</title>
</svelte:head>

<UserLayout>
    {#snippet header()}
		<Breadcrumbs data={[
			{ title: "User", href: "/user" },
			{ title: "Profile"}
		]} />
	{/snippet}

    <section class="grid grid-cols-5 gap-12 px-12 py-6">

		<div class="col-span-3 space-y-6">
			<Article
				title="Profile Information"
				subtitle="Update your account's profile information and email address."
				bodyclass="px-6"
			>
				<UpdateProfileInformationForm {mustVerifyEmail} {status} class="max-w-xl" />
			</Article>
	
			<Article
				title="Update Password"
				subtitle="Ensure your account is using a long, random password to stay secure."
				bodyclass="px-6"
			>
				<UpdatePasswordForm class="max-w-xl" />
			</Article>
	
			<Article
				title="Delete Account"
				subtitle="Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
				your account, please download any data or information that you wish to retain."
				bodyclass="px-6"
			>
				<DeleteUserForm class="max-w-xl" />
			</Article>
		</div>

    </section>
</UserLayout>