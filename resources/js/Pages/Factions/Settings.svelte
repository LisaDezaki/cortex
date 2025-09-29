<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionSettingsForm from '@/Forms/Settings/FactionSettings.svelte'
	import Flex			from '@/Components/Core/Flex.svelte'
	import Container	from '@/Components/UI/Container.svelte'
	import Heading		from '@/Components/UI/Heading.svelte'
	import PageHeader	from '@/Components/UI/PageHeader.svelte'
	import PageMenu		from '@/Components/UI/PageMenu.svelte'
	import Section		from '@/Components/UI/Section.svelte'


	//	Page props

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
				{ label: "List",			href: route('factions') },
				{ label: "Collections", 	href: route('factions.collections') },
				{ label: "Settings", 		active: true },
			]}
		/>
	{/snippet}

	{#snippet article()}
		<Flex justify="center" gap={12} class="py-12">
			<PageMenu
				items={[
					{ icon: "UserList",       label: "Overview",      href: "#overview"	},
					{ icon: "ImagesSquare",   label: "Media",         href: "#media"	},
					{ icon: "Textbox",        label: "Custom Fields", href: "#custom"	}
				]}
			/>
			<Container size="4xl">

				<Section id="overview" class="pb-12">
					<FactionSettingsForm />
				</Section>

				<Section id="media" class="pb-12">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h4" as="h6">Media</Heading>
					</Flex>
					Media
				</Section>

				<Section id="custom" class="pb-12">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h4" as="h6">Custom Fields</Heading>
					</Flex>
					Custom Fields
				</Section>

			</Container>
		</Flex>
	{/snippet}
</AuthenticatedLayout>