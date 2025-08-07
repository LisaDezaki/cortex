<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import CharacterRelationshipForm from '@/Forms/CharacterRelationshipForm.svelte'

	import Button from '@/Components/Button.svelte'
	import Card from '@/Components/Card.svelte'
	import CharacterCardNew from '@/Components/CharacterCardNew.svelte'
	import Field from '@/Components/Field.svelte'
	import Form from '@/Components/Form.svelte'
	import Heading from '@/Components/Heading.svelte'
	import Modal from '@/Components/Modal.svelte'
	import Section from '@/Components/Section.svelte'

	//  Props

	const activeProject = $page.props.activeProject.data
	
	let { character } = $props()

	//  Form

	let startData = {
		portrait: character?.portrait || null,
        name: character?.name || null,
		alias: character?.alias || null,
        description: character?.description || null,
		faction_id: character?.faction_id || null,
		location_id: character?.location_id || null,
		relationships: character?.relationships || null,
		custom_fields: character?.customFields || []
	}

	//  Process the custom fields and make sure they are
	//  populated correctly if the character is being edited
	activeProject?.customFields?.forEach((field) => {

		let characterData = character?.customFieldValues.find(f => f.customFieldId === field.id)?.value
		let value = characterData || (field.type === 'checkbox' ? false : '')

		startData.custom_fields.push({
			id: field.id,
			name: getFieldName(field.name),
			type: field.type,
			value: value,
		})

	})

	const form = useForm(startData)

	let addingRelationshipModal = $state(false)
	let activeRelationship      = $state(null)

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

	function openRelationshipModal(e, rel) {
		activeRelationship = rel
		addingRelationshipModal = true
	}

	function closeModal() {
		activeRelationship = null
		addingRelationshipModal = false
	}

	function handleRelationship(e, formData) {
		e.preventDefault();
		addingRelationshipModal = false

		if ($form.relationships.find(rel => rel.id === formData.related.id) ) {
			$form.relationships = $form.relationships.map(r => {
				return r.id === formData.related.id
					? { ...r,
						id: formData.related.id,
						name: formData.related.name,
						role: formData.related_role,
						parentRole: formData.character_role,
						slug: formData.related.slug
					} : r
				
			})
		} else {
			$form.relationships = [ ...$form.relationships, {
				id: formData.related.id,
				name: formData.related.name,
				role: formData.related_role,
				parentRole: formData.character_role,
				slug: formData.related.slug
			} ]
		}
	}
	
</script>




<Form>

	<!-- MAIN INFORMATION-->
	
	<Section class="space-y-6">

		<Heading is="h2" as="h5"
			heading={character ? "Edit Character" : "New Character"}
			subheading={character ? "Edit your character's details." : "Build a new character to add to this project."}
			class="mb-12"
		/>

		<Field
			type="file"
			id="portrait"
			layout="block"
			bind:value={$form.portrait}
			description="Upload a portrait of the character."
			errors={$form.errors.portrait}
			label="Image"
			inputClass="h-48 w-40"
		/>

		<!-- <pre>{JSON.stringify($form.portrait,null,4)}</pre> -->

		<Field
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

		<Field
			type="textarea"
			id="description"
			layout="block"
			bind:value={$form.description}
			description="A description of the character."
			errors={$form.errors.description}
			label="Description"
			rows={8}
		/>
	</Section>

	<!-- RELATIONSHIPS -->

	<Section
		title="Relationships"
		subtitle="Other characters that this character has a relationship with."
	>
		<div class="flex items-start flex-wrap gap-1.5">
			{#each $form.relationships as relationship, i}
				<Card
					class="w-32"
					title={relationship.name}
					subtitle={relationship.role}
					icon="User"
					image={relationship.portrait?.url}
					onclick={(e) => openRelationshipModal(e, relationship)}
				/>
			{/each}
			<CharacterCardNew
				class="w-32"
				onclick={openRelationshipModal}
			/>
		</div>
	</Section>

	<!-- CUSTOM FIELDS -->

	<Section
		title="Custom Fields"
		subtitle="Custom fields for this character."
		class="space-y-6"
	>
		{#each activeProject.customFields as field, i}
			<Field
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
	</Section>
	
	<!-- FORM.BUTTONS -->

	<Section class="flex justify-center gap-3 w-full">
		<Button style="hard" theme="neutral"
			type="button"
			label="Cancel"
			onclick={() => history.back()}
		/>
		<Button style="hard" theme="accent"
			type="submit"
			label="{character ? "Update" : "Create"} Character"
			onclick={submit}
			disabled={!$form.isDirty || $form.processing || $form.recentlySuccessful}
		/>
	</Section>
	
</Form>

<Modal show={addingRelationshipModal} onclose={closeModal} class="flex items-start p-6">
	{#if addingRelationshipModal}
		<CharacterRelationshipForm character={character} relationship={activeRelationship} oncancel={closeModal} onsubmit={handleRelationship} />
	{/if}
</Modal>