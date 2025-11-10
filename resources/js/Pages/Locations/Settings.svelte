<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import LocationSettingsForm from '@/Forms/Settings/LocationSettings.svelte'
	import Flex			from '@/Components/Core/Flex.svelte'
	import Stack		from '@/Components/Core/Stack.svelte'
	import Container	from '@/Components/UI/Container.svelte'
	import Heading		from '@/Components/UI/Heading.svelte'
	import PageHeader	from '@/Components/UI/PageHeader.svelte'
	import PageMenu		from '@/Components/UI/PageMenu.svelte'
	import Section		from '@/Components/UI/Section.svelte'

	/**
	 * Active character instance
	 * @type {CharacterObject}
	 */
	const customFields = $page.props.customFields?.data
	const settings     = $page.props.settings?.locations?.data

</script>



<svelte:head>
    <title>Location Settings</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Section gap={0} class="h-full overflow-hidden">


			<PageHeader class="px-20 py-3"
				title="Location Settings"
				tabs={[
					{ label: "List",			href: route('locations') },
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
						<LocationSettingsForm />
					</Section>
	
					<Section id="media" class="pb-12">
						<Flex align="center" class="mb-6 max-w-[32ch]">
							<Heading is="h3" as="h5">Media</Heading>
						</Flex>
						Media
					</Section>
	
					<Section id="custom" class="pb-12">
						<Flex align="center" class="mb-6 max-w-[32ch]">
							<Heading is="h3" as="h5">Custom Fields</Heading>
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