<script>
    import UserLayout from '@/Layouts/UserLayout.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Article from '@/Components/Article.svelte';
	import Form from '@/Components/Form'
</script>

<svelte:head>
    <title>Settings</title>
</svelte:head>

<UserLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "User", href: "/user" },
			{ title: "Settings" }
		]} />
    {/snippet}

	<section class="grid grid-cols-5 gap-12 px-12 py-6">
		<div class="col-span-3 space-y-6">
			<Article
				title="User Settings"
				subtitle="Adjust your account settings to align with your preferences."
				bodyclass="px-6"
			>
				<Form submitLabel="Update settings">
					<Form.Field>
						<Form.Switch id="username" label="Enable or disabled some feature or whatever." />
						<Form.Error for="username" />
					</Form.Field>
				</Form>
			</Article>
		</div>
	</section>

</UserLayout>