<script>
	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import {
		Form, Grid,
		UploadContext,
		UploadPreview,
		UploadTrigger
	} from '@/Components/Core'

	import Button    from '@/Components/UI/Button.svelte'
	import Card      from '@/Components/UI/Card.svelte'
	import CardNew   from '@/Components/UI/CardNew.svelte'
	import Field     from '@/Components/UI/Field.svelte'
	import Heading   from '@/Components/UI/Heading.svelte'
	import Section   from '@/Components/UI/Section.svelte'
	import Tabs      from '@/Components/UI/Tabs'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	//  Props

	const activeProject = $page.props.activeProject.data
	const customFields  = $page.props.customFields.data

	let { regionData, oncancel } = $props()

	let locations = $derived(activeProject?.locations.filter(l => l.region === null) || null)

	//  Form

	let startData = {
		slug: regionData?.slug || null,
		banner: regionData?.banner?.path || null,
		map: regionData?.map || null,
        name: regionData?.name || null,
        description: regionData?.description || null,
		custom_fields: regionData?.custom_fields || []
	}

	//  Process the custom fields and make sure they are
	//  populated correctly if the region is being edited
	// activeProject?.custom_fields?.forEach((field) => {

	// 	//  Generate a field name that is safe for use in JavaScript
	// 	let regionData = region.custom_field_values.find(f => f.custom_field_id === field.id)?.value
	// 	let value = regionData || (field.type === 'checkbox' ? false : '')
	// 	console.log('value:', value)

	// 	startData.custom_fields.push({
	// 		id: field.id,
	// 		name: getFieldName(field.name),
	// 		type: field.type,
	// 		value: value,
	// 	})

	// })

	const form = useForm(startData)

	//  Functions

    function submit(e) {
        e.preventDefault()
		if (regionData) { updateLocation(regionData.slug) }
		else            { createLocation() }
    }

	// function getFieldName(name) {
	// 	return name.replace(/[^a-zA-Z0-9]/g, '_').toLowerCase()
	// }

	// function getFieldValueByName(name) {
	// 	return $form.custom_fields.filter(field => field.name === getFieldName(name))[0]?.value || (field.type === 'checkbox' ? false : '')
	// }

	// function getFieldIndex(name) {
	// 	return $form.custom_fields.findIndex(field => field.name === getFieldName(name))
	// }

	// function getFieldIndexById(id) {
	// 	return $form.custom_fields.findIndex(field => field.id === id)
	// }

	// function createRegion() {
	// 	$form.post(route('regions.store'))
	// }

	// function updateRegion(slug) {
	// 	$form.patch(route('regions.update', {region: slug}))
	// }
	
</script>


<Form class="grid grid-cols-2 overflow-hidden">

	<!-- MAP -->

	<UploadContext class="col-span-1 relative flex aspect-square border-r bg-slate-500/10">
		<UploadPreview class="h-full w-full flex items-center justify-center">
			<UploadTrigger />
		</UploadPreview>
	</UploadContext>

	<!-- MAIN INFORMATION -->

	<!-- <div class="col-span-1 flex flex-col gap-3 p-x-6 py-3 aspect-square overflow-hidden"> -->

	<Tabs value="tab1" class="col-span-1 flex flex-col p-3 aspect-square overflow-hidden">
		<Tabs.List class="min-w-[32rem] w-full">
			<Tabs.Trigger value="tab1">General</Tabs.Trigger>
			<Tabs.Trigger value="tab2">Locations</Tabs.Trigger>
			<Tabs.Trigger value="tab3">Custom Fields</Tabs.Trigger>
		</Tabs.List>

		<Tabs.Content value="tab1" class="w-full">
			<div class="aspect-[22/9] flex items-center justify-center border-r rounded-lg bg-slate-500/10 mb-3">
				<Button style="soft" theme="accent"
					type="button"
					icon="Image"
					label="Upload Banner"
				/>
			</div>
			<Field layout="block" class="px-3" inputClass="w-full"
				type="text"
				id="name"
				label="Name"
				placeholder="Name"
				bind:value={$form.name}
				description="The name of the region."
				errors={$form.errors.name}
				required
			/>
			<Field class="px-3" inputClass="w-full"
				type="textarea"
				id="description"
				label="Description"
				placeholder="Description..."
				bind:value={$form.description}
				description="A detailed description of the region."
				errors={$form.errors.description}
				rows={4}
			/>
		</Tabs.Content>

		<Tabs.Content value="tab2" class="flex flex-col overflow-hidden w-full">
			{#if locations.length > 0}

				<Field
					label="Locations"
					description="Drag and drop locations onto the map to add them to this region."
				/>
				<ul class="space-y-1.5 overflow-y-auto">
					{#each locations as location (location.id)}
						<li class="flex items-center gap-3">
							<Thumbnail src={location.banner?.url} alt={location.name} class="cursor-grab w-8" />
							<span>{location.name}</span>
						</li>
					{/each}
				</ul>
			{:else}
				<p class="font-style-placeholder px-3">There are no locations without regions in this project.</p>
			{/if}
			<!-- <Field layout="block" inputClass="w-full"
				type="text"
				id="location"
				label="Name"
				placeholder="Name"
				bind:value={$form.name}
				description="The name of the region."
				errors={$form.errors.name}
				required
			/> -->
		</Tabs.Content>
	</Tabs>

		

		<!-- <Section class="px-6 pb-3 space-y-1.5"> -->
	
			<!-- <Field layout="block"
				type="text"
				id="slug"
				label="Slug"
				placeholder={$form.name?.toLowerCase() || "slug"}
				bind:value={$form.slug}
				description="The URL slug for this region."
				errors={$form.errors.slug}
			/> -->
	
			
		<!-- </Section> -->
	
		<!-- MEDIA -->
	
		<!-- <Section class="p-6 space-y-3">
			<Heading is="h2" as="h4" class="mb-12"
				heading="Images"
			/>
	
			<Field layout="block" inputClass="aspect-video h-40 w-72"
				type="file"
				id="banner"
				label="Banner"
				description="Upload a banner image for this region."
				icon="Image"
				placeholder="Upload a banner..."
				bind:value={$form.banner}
				preview={region?.banner?.url}
				errors={$form.errors.banner}
			/>
	
			<Field layout="block" inputClass="aspect-square h-72 w-72"
				type="file"
				id="map"
				label="Map"
				description="Upload a map for this region."
				icon="Image"
				placeholder="Upload a map..."
				bind:value={$form.map}
				preview={region?.map?.url}
				errors={$form.errors.map}
			/>
		</Section> -->
	
		<!-- <Section class="space-y-6">
			<Heading is="h3" as="h6" class="mb-6"
				heading="Custom Fields"
			/>
			{#each customFields as field, i}
				<Field layout="block" inputClass="w-full"
					type={field.type}
					id={getFieldName(field.name)}
					description={field.description}
					label={field.label || field.name}
					placeholder={field.placeholder || field.label}
					required={field.required}
					options={field.options}
					bind:value={$form.custom_fields[getFieldIndexById(field.id)].value}
				/>
			{:else}
				<p class="font-style-placeholder">There are no custom fields for Locations yet.</p>
			{/each}
		</Section> -->
	<!-- </div> -->
	
</Form>

<Section class="border-t flex items-center justify-center gap-3 p-3">
	<Button style="hard" theme="neutral"
		type="button"
		label="Cancel"
		onclick={oncancel}
	/>
	<Button style="hard" theme="accent"
		type="submit"
		disabled={!$form.isDirty || $form.processing || $form.recentlySuccessful}
		label="{regionData ? "Update" : "Create"} Region"
		onclick={submit}
	/>
</Section>