<script>
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharacterForm from '@/Forms/Character/Character.svelte'

	import Container  from '@/Components/UI/Container.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
</script>





<svelte:head>
    <title>New Character</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
				{ label: "Characters",   href: route('characters') },
			]}
			back={route('characters')}
			title="Create Character"
		/>
	{/snippet}

	{#snippet article()}
		<Container size="7xl" class="flex gap-12">
			<CharacterForm class="overflow-y-auto py-6" />
		</Container>
	{/snippet}

</AuthenticatedLayout>