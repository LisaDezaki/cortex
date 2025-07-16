<script>
	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import Card from '@/Components/Card.svelte'
	import Form from '@/Components/Form'
	import Heading from '@/Components/Heading.svelte'

	//  Props

	let project = $page.props.active_project.data
	let { character } = $props()

	//  Form

	let startData = {
		image: character?.image || null,
        name: character?.name || null,
		alias: character?.alias || null,
        description: character?.description || null,
		custom_fields: character?.custom_fields || []
	}

	//  Process the custom fields and make sure they are
	//  populated correctly if the character is being edited
	project?.custom_fields?.forEach((field) => {

		//  Generate a field name that is safe for use in JavaScript
		let characterData = character?.custom_field_values.find(f => f.custom_field_id === field.id)?.value
		let value = characterData || (field.type === 'checkbox' ? false : '')

		startData.custom_fields.push({
			id: field.id,
			name: getFieldName(field.name),
			type: field.type,
			value: value,
		})

	})

	const form = useForm(startData)

	//  Functions

    function submit(e) {
        e.preventDefault()
		if (character) { updateCharacter(character.slug) }
		else           { createCharacter() }
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

	function createCharacter() {
		$form.post(route('characters.store'))
	}

	function updateCharacter(slug) {
		$form.patch(route('characters.update', {character: slug}))
	}
	
</script>


<Form class="space-y-6">
	
	<!-- MAIN INFORMATION-->
	
	<section class="space-y-6">
		<Heading is="h2" as="h5"
			heading={character ? "Edit Character" : "New Character"}
			subheading={character ? "Edit your character's details." : "Build a new character to add to your " + project.name + " project."}
			class="mb-12"
		/>

		<Form.Field
			type="file"
			id="image"
			layout="block"
			class="w-full"
			bind:value={$form.image}
			description="Upload an image of the character."
			errors={$form.errors.image}
			label="Image"
		/>

		<Form.Field
			type="text"
			id="name"
			layout="block"
			class="w-full"
			bind:value={$form.name}
			description="The name of the character."
			errors={$form.errors.name}
			label="Name"
			required
		/>

		<Form.Field
			type="textarea"
			id="description"
			layout="block"
			bind:value={$form.description}
			description="A description of the character."
			errors={$form.errors.description}
			label="Description"
			rows={8}
		/>
	</section>

	<!-- RELATIONSHIPS -->

	<section
		title="Relationships"
		subtitle="Other characters that this character has a relationship with."
		bodyclass="grid grid-cols-6 gap-3 px-6"
	>
		{#each character?.relationships as relationship, i}
			<Card
				character={relationship}
				subtitle={relationship.role}
				image={relationship.image_path}
				href={route('characters.show', {character: relationship.slug})}
			/>
		{/each}
	</section>

	<!-- CUSTOM FIELDS -->

	<section
		title="Custom Fields"
		subtitle="Custom fields for this character."
		bodyclass="px-6 space-y-6"
	>
		{#each project.custom_fields as field, i}
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
		{/each}
	</section>
	
	<!-- FORM.BUTTONS -->

	<div class="flex justify-center gap-3 w-full pl-[50%]">
		<Button
			type="submit"
			primary={$form.isDirty}
			disabled={!$form.isDirty || $form.processing || $form.recentlySuccessful}
			label="{character ? "Update" : "Create"} Character"
			onclick={submit}
		/>
		<Button
			type="button"
			secondary
			label="Cancel"
			onclick={() => history.back()}
		/>
	</div>
	
</Form>