<script>
	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import Card from '@/Components/Card.svelte'
	import Form from '@/Components/Form'
	import Heading from '@/Components/Heading.svelte'
	import Section from '@/Components/Section.svelte'
	import Tabs from '@/Components/Tabs'

	//  Props

	let project = $page.props.active_project.data
	let { location } = $props()

	//  Form

	let startData = {
		banner: location?.banner || null,
		map: location?.map || null,
        name: location?.name || null,
        description: location?.description || null,
		custom_fields: location?.custom_fields || []
	}

	//  Process the custom fields and make sure they are
	//  populated correctly if the location is being edited
	// project?.custom_fields?.forEach((field) => {

	// 	//  Generate a field name that is safe for use in JavaScript
	// 	let locationData = location.custom_field_values.find(f => f.custom_field_id === field.id)?.value
	// 	let value = locationData || (field.type === 'checkbox' ? false : '')
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
		if (location) { updateLocation(location.slug) }
		else           { createLocation() }
    }

	function getFieldName(name) {
		return name.replace(/[^a-zA-Z0-9]/g, '_').toLowerCase()
	}

	function getFieldValueByName(name) {
		return $form.custom_fields.filter(field => field.name === getFieldName(name))[0]?.value || (field.type === 'checkbox' ? false : '')
	}

	function getFieldIndex(name) {
		return $form.custom_fields.findIndex(field => field.name === getFieldName(name))
	}

	function getFieldIndexById(id) {
		return $form.custom_fields.findIndex(field => field.id === id)
	}

	function createLocation() {
		$form.post(route('locations.store'))
	}

	function updateLocation(slug) {
		$form.patch(route('locations.update', {location: slug}))
	}
	
</script>

<Tabs value="location" class="max-w-4xl">

	<Section>
		<Tabs.List class="max-w-64 mx-auto">
			<Tabs.Trigger value="location">Location</Tabs.Trigger>
			<Tabs.Trigger value="region">Region</Tabs.Trigger>
		</Tabs.List>
	</Section>

	<Tabs.Content value="location" class="space-y-6 mt-6">
		<Form class="col-span-3 space-y-6">

			<pre>{JSON.stringify(location,null,4)}</pre>

			<Section class="space-y-6">

				<Heading is="h2" as="h5"
					heading={location ? "Edit Location" : "New Location"}
					subheading={location ? "Edit this location's details." : `Build a new location to add to the ${project.name} project.`}
					class="mb-12"
				/>

				<!-- FORM.MAIN -->

				<!-- <Form.Field
					type="file"
					id="banner"
					layout="block"
					class="w-full"
					bind:value={$form.banner}
					description="Upload a banner image for this location."
					errors={$form.errors.banner}
					label="Map"
				/> -->

				<!-- <Form.Field
					type="file"
					id="map"
					layout="block"
					class="w-full"
					bind:value={$form.map}
					description="Upload a map for this location."
					errors={$form.errors.map}
					label="Map"
				/> -->

				<Form.Field
					type="text"
					id="name"
					layout="block"
					class="w-full"
					bind:value={$form.name}
					description="The name of the location."
					errors={$form.errors.name}
					label="Name"
					required
				/>

				<Form.Field
					type="textarea"
					id="description"
					layout="block"
					bind:value={$form.description}
					description="A detailed description of the location."
					errors={$form.errors.description}
					label="Description"
					rows={8}
				/>
			</Section>

			<Section>
				<Heading is="h3" as="h6"
					heading="Characters"
					subheading="Characters that are found at this location."
					class="mb-6"
				/>
				{#each location?.members as member, i}
					<Card
						class="aspect-[3/4]"
						title={member.name}
						subtitle={member.role}
						image={member.image_path}
						href={route('characters.show', {character: member.slug})}
					/>
				{/each}
			</Section>

			<Section
				title="Custom Fields"
				subtitle="Custom fields for this location."
				bodyclass="px-6 space-y-6"
			>
				<!-- {#each project.custom_fields as field, i}
					<Form.Field
						type={field.type}
						id={getFieldName(field.name)}
						layout="block"
						class="w-full"
						description={field.description}
						label={field.label || field.name}
						placeholder={field.placeholder || field.name}
						required={field.required}
						options={field.options}
						bind:value={$form.custom_fields[getFieldIndexById(field.id)].value}
					/>
				{/each} -->
			</Section>
			
			<Section class="flex items-center justify-center gap-3">
				<Button style="hard" theme="neutral"
					type="button"
					secondary
					label="Cancel"
					onclick={() => history.back()}
				/>
				<Button style="hard" theme="accent"
					type="submit"
					primary={$form.isDirty}
					disabled={!$form.isDirty || $form.processing || $form.recentlySuccessful}
					label="{location ? "Update" : "Create"} Location"
					onclick={submit}
				/>
			</Section>

		</Form>

	</Tabs.Content>

	<Tabs.Content value="region" class="space-y-6 mt-6">

		<Form class="col-span-3 space-y-6">

			<Section class="space-y-6">

				<Heading is="h2" as="h5"
					heading={location ? "Edit Region" : "New Region"}
					subheading={location ? "Edit this region's details." : `Build a new region to add to the ${project.name} project.`}
					class="mb-12"
				/>

				<!-- FORM.MAIN -->

				<!-- <Form.Field
					type="file"
					id="banner"
					layout="block"
					class="w-full"
					bind:value={$form.banner}
					description="Upload a logo, icon, or sigil for this location."
					errors={$form.errors.banner}
					label="Image"
				/> -->

				<Form.Field
					type="text"
					id="name"
					layout="block"
					class="w-full"
					bind:value={$form.name}
					description="The name of the location."
					errors={$form.errors.name}
					label="Name"
					required
				/>

				<Form.Field
					type="textarea"
					id="description"
					layout="block"
					bind:value={$form.description}
					description="A detailed description of the location."
					errors={$form.errors.description}
					label="Description"
					rows={8}
				/>
			</Section>

			<Section>
				<Heading is="h3" as="h6"
					heading="Characters"
					subheading="Characters that are found at this location."
					class="mb-6"
				/>
				{#each location?.members as member, i}
					<Card
						class="aspect-[3/4]"
						title={member.name}
						subtitle={member.role}
						image={member.image_path}
						href={route('characters.show', {character: member.slug})}
					/>
				{/each}
			</Section>

			<Section
				title="Custom Fields"
				subtitle="Custom fields for this location."
				bodyclass="px-6 space-y-6"
			>
				<!-- {#each project.custom_fields as field, i}
					<Form.Field
						type={field.type}
						id={getFieldName(field.name)}
						layout="block"
						class="w-full"
						description={field.description}
						label={field.label || field.name}
						placeholder={field.placeholder || field.name}
						required={field.required}
						options={field.options}
						bind:value={$form.custom_fields[getFieldIndexById(field.id)].value}
					/>
				{/each} -->
			</Section>
			
			<Section class="flex items-center justify-center gap-3">
				<Button style="hard" theme="neutral"
					type="button"
					secondary
					label="Cancel"
					onclick={() => history.back()}
				/>
				<Button style="hard" theme="accent"
					type="submit"
					primary={$form.isDirty}
					disabled={!$form.isDirty || $form.processing || $form.recentlySuccessful}
					label="{location ? "Update" : "Create"} Location"
					onclick={submit}
				/>
			</Section>

		</Form>

	</Tabs.Content>
</Tabs>

