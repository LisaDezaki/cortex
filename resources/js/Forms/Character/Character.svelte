<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import CharacterRelationshipForm from '@/Forms/Character/Relationship.svelte'
	
	import { Flex, Form, Grid, Tabs } from '@/Components/Core'

	import ArticleTabs  from '@/Components/UI/ArticleTabs.svelte'
	import Button  		from '@/Components/UI/Button.svelte'
	import Card    		from '@/Components/UI/Card.svelte'
	import CardNew 		from '@/Components/UI/CardNew.svelte'
	import Field   		from '@/Components/UI/Field.svelte'
	import Heading 		from '@/Components/UI/Heading.svelte'
	import Icon    		from '@/Components/UI/Icon.svelte'
	import Modal   		from '@/Components/UI/Modal.svelte'
	import PageMenu 	from '@/Components/UI/PageMenu.svelte'
	import Section 		from '@/Components/UI/Section.svelte'

	import Map   		from '@/Components/Features/Location/Map.svelte'

	//  Props

	const activeProject = $page.props.activeProject.data
	const customFields  = $page.props.customFields.data
	const appearanceTraits  = $page.props.traitsAppearance
	const personalityTraits = $page.props.traitsPersonality

	let { character, class:className } = $props()

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
		appearance: character?.appearance || [],
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
		if (character) { updateCharacter() }
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

	function updateCharacter() {
		$form.patch(route('characters.update', {character: character.slug}))
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





{#snippet actions()}
	<Flex items="center" justify="center" gap={3}>
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
	</Flex>
{/snippet}



<Form class={className}>

	<ArticleTabs value="details" tabs={[
		{ icon: "UserList",       label: "Details",       value: "details"       },
		{ icon: "TagSimple",      label: "Tags",          value: "tags"          },
		{ icon: "Handshake",      label: "Relationships", value: "relationships" },
		{ icon: "FlagBannerFold", label: "Factions",      value: "factions"      },
		{ icon: "Backpack",       label: "Inventory",     value: "items"         },
		{ icon: "MapPinArea",     label: "Location",      value: "location"      },
		{ icon: "ImagesSquare",   label: "Media",         value: "media"         },
		{ icon: "Textbox",        label: "Custom Fields", value: "customfields"  }
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
				description="The name of the character."
				errors={$form.errors.name}
				required
			/>

			<Field layout="block" inputClass="w-full"
				type="text"
				id="alias"
				label="Alias"
				description="An alternative name that the character is known by."
				placeholder="Alias"
				bind:value={$form.alias}
				errors={$form.errors.name}
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

			{@render actions()}
		</Tabs.Content>

		<Tabs.Content value="tags">

			<Heading is="h3" as="h5" class="mb-6"
				heading="Tags"
			/>

			<Field layout="block" inputClass="w-full"
				type="combobox"
				id="appearance"
				label="Appearance"
				description="What do they look like physically?"
				placeholder="Appearance traits..."
				bind:value={$form.appearance}
				errors={$form.errors.appearance}
				options={appearanceTraits.map(t => ({ label: t, value: t }))}
				multiple
			/>

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

			{@render actions()}
		</Tabs.Content>

		<!-- Relationships -->

		<Tabs.Content value="relationships">
			<Heading is="h3" as="h5" class="mb-6"
				heading="Relationships"
			/>
			<Grid cols={6}>
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
			</Grid>
			{@render actions()}
		</Tabs.Content>

		<!-- Factions -->

		<Tabs.Content value="factions">
			<Heading is="h3" as="h5" class="mb-6"
				heading="Factions"
			/>

			<Field layout="block" inputClass="w-full"
				type="select"
				id="faction"
				description="Which faction does this character belong to?"
				label="Faction"
				placeholder="Select faction..."
				options={factions.map(f => ({ image: f.emblem?.url, label: f.name, value: f.id }))}
				bind:value={$form.faction_id}
			/>
			{@render actions()}
		</Tabs.Content>

		<!-- Inventory -->

		<Tabs.Content value="items">

			<Heading is="h3" as="h5" class="mb-6"
				heading="Inventory"
			/>

			{@render actions()}
		</Tabs.Content>

		<!-- Location -->

		<Tabs.Content value="location">

			<Heading is="h3" as="h5" class="mb-6"
				heading="Location"
			/>

			<Field layout="block" inputClass="w-full"
				type="select"
				id="location"
				description="In which location is this character found?"
				label="Location"
				placeholder="Select location..."
				options={locations.map(l => ({ image: l.banner?.url, label: l.name, value: l.id }))}
				bind:value={$form.location_id}
			/>

			{#if $form.location_id}
				<Map class="aspect-square w-full" location={locations.find(l => l.id == $form.location_id)} />
			{/if}

			{@render actions()}
		</Tabs.Content>

		<!-- Media -->

		<Tabs.Content value="media">
			<Heading is="h3" as="h5" class="mb-6"
				heading="Media"
			/>
			<Field layout="block" inputClass="w-56"
				type="file"
				id="portrait"
				aspect="square"
				label="Image"
				description="Upload a portrait of the character."
				icon="Image"
				placeholder="Upload a portrait..."
				preview={character?.portrait?.url}
				bind:value={$form.portrait}
				errors={$form.errors.portrait}
			/>
			{@render actions()}
		</Tabs.Content>

		<!-- CUSTOM FIELDS -->

		<Tabs.Content value="customfields">
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
				<p class="font-style-placeholder">There are no custom fields for Factions yet.</p>
			{/each}
			{@render actions()}
		</Tabs.Content>

	<!-- </Tabs> -->
	</ArticleTabs>
</Form>

<Modal show={addingRelationshipModal} onclose={closeModal} class="flex items-start p-6">
	{#if addingRelationshipModal}
		<CharacterRelationshipForm character={character} relationship={activeRelationship} oncancel={closeModal} onsubmit={handleRelationship} />
	{/if}
</Modal>