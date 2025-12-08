<script>

	import { page, useForm } from '@inertiajs/svelte'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import {
		Flex, Form, Grid, Inline,
		PanZoom, Stack,
		UploadContext,
		UploadPreview,
		UploadTrigger
	 } from '@/Components/Core'

	import Avatar      from '@/Components/UI/Avatar.svelte'
	import Badge       from '@/Components/UI/Badge.svelte'
	import Button      from '@/Components/UI/Button.svelte'
	import Checkbox    from '@/Components/UI/Inputs/Checkbox.svelte'
	import Dropdown    from '@/Components/UI/Dropdown.svelte'
	import Field       from '@/Components/UI/Field.svelte'
	import Heading     from '@/Components/UI/Heading.svelte'
	import Input       from '@/Components/UI/Input.svelte'
	import PageHeader  from '@/Components/UI/PageHeader.svelte'
	import Section     from '@/Components/UI/Section.svelte'
	import Table       from '@/Components/UI/Table'
	import Thumbnail   from '@/Components/UI/Thumbnail.svelte'

	let activeTab = $state('forms')

	const activeProject = $page.props.activeProject?.data

	const form = useForm({	
	})
	
</script>



<svelte:head>
    <title>{activeProject.name || 'Dashboard'}</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Section class="h-full overflow-y-auto px-20 py-12 w-full">
			<Heading is="h2" as="h4">Todo List</Heading>
			<Stack gap={0}>

				
				<Flex align="center" gap={0} class="font-style-h6 mt-12"><Input type="checkbox" />Modals and/or methods for ALL possible entity update interactions</Flex>
				<Stack gap={0} class="mt-3 ml-12">
					<strong class="font-style-large mt-6">Character</strong>
					<Flex align="center" gap={0}><Input type="checkbox" checked />OpenModal()</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />SetData(Name,Alias,Description)</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />SetRelated(Characters,Factions,Locations)</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" checked />SetMedia(Portrait,Banner)</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />SetCustomField(Class,Level,Species)</Flex>
					
					<strong class="font-style-large mt-6">Faction</strong>
					<Flex align="center" gap={0}><Input type="checkbox" checked />OpenModal()</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />SetData(Name,Type,Description)</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />SetRelated(Characters,Factions,Locations)</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" checked />SetMedia(Emblem,Banner)</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />SetCustomField()</Flex>
					<!-- <Flex align="center" gap={0}><Input type="checkbox" />SetAlliances(faction-factions)</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />SetHeadquarters(faction-location)</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />SetMembers(faction-characters)</Flex> -->

					<strong class="font-style-large mt-6">Location</strong>
					<Flex align="center" gap={0}><Input type="checkbox" checked />OpenModal()</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />SetData(Name,Type,Description)</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />SetMarkers()</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" checked />SetMedia(Map,Banner)</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />SetCustomField()</Flex>
				</Stack>


				<Flex align="center" gap={0} class="font-style-h6 mt-12"><Input type="checkbox" />Settings for each entity with checkboxes to enable preset properties:</Flex>
				<Stack gap={0} class="mt-3 ml-12">
					<strong class="font-style-large mt-6">Character</strong>
					<Flex align="center" gap={0}><Input type="checkbox" />Appearance</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />Personality</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />Species</Flex>

					<strong class="font-style-large mt-6">Faction</strong>
					<Flex align="center" gap={0}><Input type="checkbox" />Alliances</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />Leader</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />Ranks</Flex>
					<Flex align="center" gap={0}><Input type="checkbox" />Rules</Flex>

					<strong class="font-style-large mt-6">Location</strong>
					<Flex align="center" gap={0}><Input type="checkbox" />Biome/Climate/Weather</Flex>
				</Stack>

					
			</Stack>
		</Section>
	{/snippet}
</AuthenticatedLayout>
