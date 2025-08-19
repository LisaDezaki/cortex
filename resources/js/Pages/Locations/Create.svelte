<script>
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import LocationForm from '@/Forms/Location/Location.svelte'

	import Container from '@/Components/UI/Container.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
</script>





<svelte:head>
    <title>New Location</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
				{ label: "Locations",   href: route('locations') },
			]}
			back={route('locations')}
			title="Create Location"
		/>
	{/snippet}

	{#snippet article()}
		<Container size="7xl" class="flex gap-12">
			<LocationForm class="overflow-y-auto py-6" />
		</Container>
	{/snippet}

</AuthenticatedLayout>