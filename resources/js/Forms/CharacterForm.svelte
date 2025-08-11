<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import CharacterRelationshipForm from '@/Forms/CharacterRelationshipForm.svelte'

	import Button from '@/Components/Button.svelte'
	import Card from '@/Components/Card.svelte'
	import CardGrid from '@/Components/CardGrid.svelte'
	import CardNew from '@/Components/CardNew.svelte'
	import Field from '@/Components/Field.svelte'
	import Form from '@/Components/Form.svelte'
	import Heading from '@/Components/Heading.svelte'
	import Modal from '@/Components/Modal.svelte'
	import Section from '@/Components/Section.svelte'

	//  Props

	const activeProject = $page.props.activeProject.data
	const customFields  = $page.props.customFields.data
	const personalityTraits = $page.props.traitsPersonality

	let { character } = $props()

	let factions  = $derived(activeProject?.factions)
	let locations = $derived(activeProject?.locations)

	//  Form

	let startData = {
        slug: character?.slug || null,
		portrait: character?.portrait?.path || null,
        name: character?.name || null,
		alias: character?.alias || null,
        description: character?.description || null,
		faction_id: character?.factions?.[0]?.id || null,
		location_id: character?.location?.id || null,
		relationships: character?.relationships || null,
		personality: character?.personality || [],
		custom_fields: character?.customFields || []
	}

	//  Process the custom fields and make sure they are
	//  populated correctly if the character is being edited
	customFields?.forEach((field) => {

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

	function getRelationship(slug) {
		return character.relationships.find(r => r.slug === slug)
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
	
	<Section class="space-y-3">

		<Heading is="h2" as="h5" class="mb-12"
			heading={character ? "Edit Character" : "New Character"}
		/>

		<!-- <pre>{JSON.stringify(personalityTraits,null,3)}</pre> -->

		<!-- Slug -->

		<!-- <Field layout="block"
			type="text"
			id="slug"
			label="Slug"
			placeholder={$form.name?.toLowerCase() || "slug"}
			bind:value={$form.slug}
			description="The URL slug for this character."
			errors={$form.errors.name}
		/> -->

		<!-- Name -->

		<Field layout="block" inputClass="w-full"
			type="text"
			id="name"
			label="Name"
			placeholder="Name"
			bind:value={$form.name}
			description="The name of the character."
			errors={$form.errors.name}
			required
		/>

		<!-- Alias -->

		<Field layout="block" inputClass="w-full"
			type="text"
			id="alias"
			label="Alias"
			description="An alternative name that the character is known by."
			placeholder="Alias"
			bind:value={$form.alias}
			errors={$form.errors.name}
		/>

		

		<!-- Portrait -->

		<!-- <Field layout="block" inputClass="aspect-square h-72 w-72"
			type="file"
			id="portrait"
			label="Image"
			description="Upload a portrait of the character."
			icon="Image"
			placeholder="Upload a portrait..."
			preview={character?.portrait?.url}
			bind:value={$form.portrait}
			errors={$form.errors.portrait}
		/> -->

		<!-- Faction -->

		<Field layout="block" inputClass="w-full"
			type="select"
			id="faction"
			description="Which faction does this character belong to?"
			label="Faction"
			placeholder="Select faction..."
			options={factions.map(f => ({ image: f.emblem?.url, label: f.name, value: f.id }))}
			bind:value={$form.faction_id}
		/>

		<!-- Location -->

		<Field layout="block" inputClass="w-full"
			type="select"
			id="location"
			description="In which location is this character found?"
			label="Location"
			placeholder="Select location..."
			options={locations.map(l => ({ image: l.banner?.url, label: l.name, value: l.id }))}
			bind:value={$form.location_id}
		/>

		<!-- Description -->

		<Field layout="block" inputClass="w-full"
			type="combobox"
			id="personality"
			label="Personality"
			description="What are they like as a person?"
			placeholder="Personality traits..."
			bind:value={$form.personality}
			errors={$form.errors.personality}
			options={personalityTraits.map(t => ({ label: t, value: t }))}
			multiple
		/>

		<Field inputClass="w-full"
			type="textarea"
			id="description"
			label="Description"
			placeholder="Description..."
			bind:value={$form.description}
			description="A description of the character."
			errors={$form.errors.description}
			rows={5}
		/>

	</Section>

	<!-- CUSTOM FIELDS -->

	<Section class="space-y-6">
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
			<p class="font-style-placeholder">There are no custom fields for Factions yet.</p>
		{/each}
	</Section>

	<!-- RELATIONSHIPS -->

	<Section>
		<Heading is="h3" as="h6" class="mb-6"
			heading="Relationships"
		/>
		<CardGrid cols={5}>
			{#each $form.relationships as rel, i}
				<Card aspect="square"
					icon="User"
					image={getRelationship(rel.slug)?.portrait?.url}
					title={getRelationship(rel.slug)?.name}
					subtitle={getRelationship(rel.slug)?.role}
					onclick={(e) => openRelationshipModal(e, getRelationship(rel.slug))}
				/>
			{/each}
			<CardNew aspect="square"
				onclick={openRelationshipModal}
			/>
		</CardGrid>
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