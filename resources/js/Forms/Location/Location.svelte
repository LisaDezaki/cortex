<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import { Flex, Form, Grid, Tabs } from '@/Components/Core'
	
	import ArticleTabs  from '@/Components/UI/ArticleTabs.svelte'
	import Button   from '@/Components/UI/Button.svelte'
	import Card     from '@/Components/UI/Card.svelte'
	import CardNew  from '@/Components/UI/CardNew.svelte'
	import Field    from '@/Components/UI/Field.svelte'
	import Heading  from '@/Components/UI/Heading.svelte'
	import Section  from '@/Components/UI/Section.svelte'

	//  Props

	const activeProject = $page.props.activeProject.data
	const customFields  = $page.props.customFields.data

	let { class:className, location } = $props()

	//  Form

	let startData = {
		slug: location?.slug || null,
		banner: location?.banner?.path || null,
		map: location?.map || null,
        name: location?.name || null,
        description: location?.description || null,
		custom_fields: location?.custom_fields || []
	}

	//  Process the custom fields and make sure they are
	//  populated correctly if the location is being edited
	// activeProject?.custom_fields?.forEach((field) => {

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





{#snippet actions()}
	<Flex items="center" justify="center" gap={3}>
		<Button style="hard" theme="neutral"
			type="button"
			label="Cancel"
			onclick={() => history.back()}
		/>
		<Button style="hard" theme="accent"
			type="submit"
			label="{location ? "Update" : "Create"} Location"
			onclick={submit}
			disabled={!$form.isDirty || $form.processing || $form.recentlySuccessful}
		/>
	</Flex>
{/snippet}



<Form class={className}>

	<ArticleTabs value="details" tabs={[
		{ icon: "MapPinArea",   label: "Details",       value: "details" },
		{ icon: "Compass",      label: "Map",           value: "map"     },
		{ icon: "UsersThree",   label: "People",        value: "people"  },
		{ icon: "ImagesSquare", label: "Media",         value: "media"   },
		{ icon: "Textbox",      label: "Custom Fields", value: "custom"  }
	]}>

		<!-- Details -->

		<Tabs.Content value="details">
			<Heading is="h3" as="h5" class="mb-6"
				heading="Details"
			/>

			<Field layout="block" inputClass="w-full"
				type="text"
				id="name"
				label="Name"
				placeholder="Name"
				bind:value={$form.name}
				description="The name of the location."
				errors={$form.errors.name}
				required
			/>

			<Field layout="block" inputClass="w-full"
				type="textarea"
				id="description"
				label="Description"
				placeholder="Description..."
				bind:value={$form.description}
				description="A detailed description of the location."
				errors={$form.errors.description}
				rows={8}
			/>

			{@render actions()}
		</Tabs.Content>

		<!-- Map -->

		<Tabs.Content value="map">
			<Heading is="h3" as="h5" class="mb-6"
				heading="Map"
			/>



			{@render actions()}
		</Tabs.Content>

		<!-- People -->

		<Tabs.Content value="people">
			<Heading is="h3" as="h5" class="mb-6"
				heading="People"
			/>

			<Grid cols={5}>
				{#each location?.characters as character, i}
					<Card aspect="square" class="w-full"
						icon="User"
						image={character.portrait?.url}
						title={character.name}
						subtitle={character.role}
						href={route('characters.show', {character: character.slug})}
					/>
				{/each}
				<CardNew aspect="square" class="w-full"
				/>
			</Grid>

			{@render actions()}
		</Tabs.Content>

		<!-- Media -->

		<Tabs.Content value="media">
			<Heading is="h3" as="h5" class="mb-6"
				heading="Media"
			/>

			<Field layout="block" inputClass="aspect-video h-40 w-72"
				type="file"
				id="banner"
				label="Banner"
				description="Upload a banner image for this location."
				icon="Image"
				placeholder="Upload a banner..."
				bind:value={$form.banner}
				preview={location?.banner?.url}
				errors={$form.errors.banner}
			/>

			<Field layout="block" inputClass="aspect-square h-72 w-72"
				type="file"
				id="map"
				label="Map"
				description="Upload a map for this location."
				icon="Image"
				placeholder="Upload a map..."
				bind:value={$form.map}
				preview={location?.map?.url}
				errors={$form.errors.map}
			/>

			{@render actions()}
		</Tabs.Content>

		<!-- Custom Fields -->

		<Tabs.Content value="custom">
			<Heading is="h3" as="h5" class="mb-6"
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

			{@render actions()}
		</Tabs.Content>

	</ArticleTabs>

</Form>