<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionSettingsForm from '@/Forms/Settings/FactionSettings.svelte'
	import Flex			from '@/Components/Core/Flex.svelte'
	import Stack		from '@/Components/Core/Stack.svelte'
	import Container	from '@/Components/UI/Container.svelte'
	import Heading		from '@/Components/UI/Heading.svelte'
	import PageHeader	from '@/Components/UI/PageHeader.svelte'
	import PageMenu		from '@/Components/UI/PageMenu.svelte'
	import Section		from '@/Components/UI/Section.svelte'


	//	Page props

	const customFields = $page.props.customFields?.data
	const settings     = $page.props.settings?.factions?.data

</script>



<svelte:head>
    <title>Faction Settings</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Section gap={0} class="h-full overflow-hidden">


			<PageHeader class="px-20 py-3"
				title="Faction Settings"
				tabs={[
					{ label: "List",			href: route('factions') },
					// { label: "Collections", 	href: route('factions.collections') },
					{ label: "Settings", 		active: true },
				]}
			/>

			<Flex gap={12} class="px-20 py-6 w-full">
				<PageMenu
					items={[
						{ icon: "UserList",       label: "Overview",      href: "#overview"	},
						{ icon: "ImagesSquare",   label: "Media",         href: "#media"	},
						{ icon: "Textbox",        label: "Custom Fields", href: "#custom"	}
					]}
				/>
				<Stack>

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

				</Stack>
			</Flex>
		</Section>
	{/snippet}

	{#snippet sidebar()}
		<div class="bg-slate-50 min-w-80 shadow-lg"></div>
	{/snippet}
</AuthenticatedLayout>