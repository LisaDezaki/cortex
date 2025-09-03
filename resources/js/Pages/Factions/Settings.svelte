<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionSettingsForm from '@/Forms/Faction/Settings.svelte'

	import { Flex }   from '@/Components/Core'
	import Container  from '@/Components/UI/Container.svelte'
	import Heading    from '@/Components/UI/Heading.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'
	import Section    from '@/Components/UI/Section.svelte'

	const activeProject = $page.props.activeProject.data
	const settings = $page.props.settings?.factions?.data

</script>

<svelte:head>
    <title>Faction Settings</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			title="Faction Settings"
			tabs={[
				{ icon: "ListBullets",	label: "List",			href: route('factions') },
				{ icon: "SquaresFour",	label: "Collections", 	href: route('factions.collections') },
				{ icon: "GearFine",		label: "Settings", 		active: true },
			]}
		/>
	{/snippet}

	{#snippet article()}
		<Flex justify="center" gap={12} class="py-12">
			<PageMenu
				items={[
					{ icon: "UserList",       label: "Overview",      href: "#overview",      active: $page.url.endsWith('#overview') },
					{ icon: "ImagesSquare",   label: "Media",         href: "#media",         active: $page.url.endsWith('#media') },
					{ icon: "Textbox",        label: "Custom Fields", href: "#customfields",  active: $page.url.endsWith('#customfields') }
				]}
			/>
			<Container size="4xl">

				<Section id="overview" class="pb-12">
					<FactionSettingsForm />
					<!-- <Form class="py-12">
						<Field layout="block"
							name="enable_factions"
							type="switch"
							label="Enable Factions"
							description="Enable factions for this project?"
						/>
					</Form> -->
				</Section>
			</Container>
		</Flex>
	{/snippet}

</AuthenticatedLayout>