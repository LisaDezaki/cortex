<script>

	import { page, useForm } from '@inertiajs/svelte'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import { Flex, Stack } from '@/Components/Core'

	import Heading     from '@/Components/UI/Heading.svelte'
	import Input       from '@/Components/UI/Input'
	import Section     from '@/Components/UI/Section.svelte'

	const activeProject = $page.props.activeProject?.data
	
</script>



<svelte:head>
    <title>{activeProject.name || 'Dashboard'}</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Section class="h-full overflow-y-auto px-20 py-12 w-full">
			<Heading is="h2" as="h4">Todo List</Heading>
			<Stack gap={0}>

				<Flex align="center" gap={0} class="font-style-h6 mt-12"><Input type="checkbox" />Reduce custom entity components</Flex>
				<Stack gap={0} class="mt-3 ml-12">
					<Flex align="center" gap={0}><Input.Checkbox checked />Generic ControlBar component for all index pages</Flex>
					<Flex align="center" gap={0}><Input.Checkbox checked />Generic SidePanel component for all index pages</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />Generic EntityTable component for all index pages</Flex>
				</Stack>

				<Flex align="center" gap={0} class="font-style-h6 mt-12"><Input type="checkbox" />Input fixes</Flex>
				<Stack gap={0} class="mt-3 ml-12">
					<Flex align="center" gap={0}><Input.Checkbox />X to clear input value (top right corner)</Flex>
				</Stack>

				<Flex align="center" gap={0} class="font-style-h6 mt-12"><Input type="checkbox" />Breakpoints</Flex>
				<Stack gap={0} class="mt-3 ml-12">
					<Flex align="center" gap={0}><Input.Checkbox />Collapsed min-nav on left</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />Horizontal nav bar for mobile</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />Pad-X & Container Max for articles</Flex>
				</Stack>

				<Flex align="center" gap={0} class="font-style-h6 mt-12"><Input type="checkbox" />PanZoom</Flex>
				<Stack gap={0} class="mt-3 ml-12">
					<Flex align="center" gap={0}><Input.Checkbox />PanZoom component fixed</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />MapMarkers don't resize when base image resizes (zooms)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />Zoom based on mouse position</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />Set location coordinates for Map Marker items</Flex>
				</Stack>

				<Flex align="center" gap={0} class="font-style-h6 mt-12"><Input type="checkbox" />Reorderable List</Flex>
				<Stack gap={0} class="mt-3 ml-12">
					<Flex align="center" gap={0}><Input.Checkbox />Reorderable.List component fixed</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />Reorderable custom fields</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />Reorderable custom field options</Flex>
				</Stack>


				<Flex align="center" gap={0} class="font-style-h6 mt-12"><Input type="checkbox" />Modals and/or methods for ALL possible entity update interactions</Flex>
				<Stack gap={0} class="mt-3 ml-12">
					<strong class="font-style-large mt-6">Character</strong>
					<Flex align="center" gap={0}><Input.Checkbox checked />OpenModal()</Flex>
					<Flex align="center" gap={0}><Input.Checkbox checked />SetRelated(Characters,Factions,Locations)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox checked />SetMedia(Portrait,Banner)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox checked />SetTags(Appearance,Personality)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox checked />SetValue(Name,Alias,Description)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox checked />SetCustomFieldValue(Class,Level,Species)</Flex>
					
					<strong class="font-style-large mt-6">Faction</strong>
					<Flex align="center" gap={0}><Input.Checkbox checked />OpenModal()</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />SetData(Name,Type,Description)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />SetRelated(Characters,Factions,Locations)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox checked />SetMedia(Emblem,Banner)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox checked />SetTags(Aesthetic,Ideology)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />SetCustomField()</Flex>
					<!-- <Flex align="center" gap={0}><Input.Checkbox />SetAlliances(faction-factions)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />SetHeadquarters(faction-location)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />SetMembers(faction-characters)</Flex> -->

					<strong class="font-style-large mt-6">Location</strong>
					<Flex align="center" gap={0}><Input.Checkbox checked />OpenModal()</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />SetData(Name,Type,Description)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />SetMarkers()</Flex>
					<Flex align="center" gap={0}><Input.Checkbox checked />SetMedia(Map,Banner)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox checked />SetTags(Climate)</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />SetCustomField()</Flex>
				</Stack>


				<Flex align="center" gap={0} class="font-style-h6 mt-12"><Input.Checkbox />Settings for each entity with checkboxes to enable preset properties:</Flex>
				<Stack gap={0} class="mt-3 ml-12">
					<strong class="font-style-large mt-6">Character</strong>
					<Flex align="center" gap={0}><Input.Checkbox />Appearance</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />Personality</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />Species</Flex>

					<strong class="font-style-large mt-6">Faction</strong>
					<Flex align="center" gap={0}><Input.Checkbox />Alliances</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />Leader</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />Ranks</Flex>
					<Flex align="center" gap={0}><Input.Checkbox />Rules</Flex>

					<strong class="font-style-large mt-6">Location</strong>
					<Flex align="center" gap={0}><Input.Checkbox />Biome/Climate/Weather</Flex>
				</Stack>


			</Stack>
		</Section>
	{/snippet}
</AuthenticatedLayout>
