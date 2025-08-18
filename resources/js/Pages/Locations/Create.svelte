<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import LocationsPanel from '@/Partials/LocationsPanel.svelte'
	import LocationForm from '@/Forms/Location/Location.svelte'
	import Back from '@/Components/UI/Back.svelte'
	import Container from '@/Components/UI/Container.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import PageMenu from '@/Components/UI/PageMenu.svelte'

	const activeProject = $page.props.activeProject.data

</script>





<svelte:head>
    <title>{activeProject.name} / New Location</title>
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
			<PageMenu
				items={[
					{ icon: "MapPinArea",   label: "Details",       href: "#bio",          active: $page.url.endsWith('#bio')          },
					{ icon: "Compass",      label: "Map",           href: "#map",          active: $page.url.endsWith('#map')          },
					{ icon: "UsersThree",   label: "People",        href: "#people",       active: $page.url.endsWith('#people')       },
					{ icon: "ImagesSquare", label: "Media",         href: "#media",        active: $page.url.endsWith('#media')        },
					{ icon: "Textbox",      label: "Custom Fields", href: "#customfields", active: $page.url.endsWith('#customfields') }
				]}
			/>
			<LocationForm class="py-6" />
		</Container>
	{/snippet}

</AuthenticatedLayout>