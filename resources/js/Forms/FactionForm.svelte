<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

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

	let { faction } = $props()

	//  Form

	let startData = {
		emblem: faction?.emblem?.path || null,
        name: faction?.name || null,
        description: faction?.description || null,
		custom_fields: faction?.custom_fields || []
	}

	//  Process the custom fields and make sure they are
	//  populated correctly if the faction is being edited
	// activeProject?.custom_fields?.forEach((field) => {

	// 	let factionData = faction.custom_field_values.find(f => f.custom_field_id === field.id)?.value
	// 	let value = factionData || (field.type === 'checkbox' ? false : '')
	// 	console.log('value:', value)

	// 	startData.custom_fields.push({
	// 		id: field.id,
	// 		name: getFieldName(field.name),
	// 		type: field.type,
	// 		value: value,
	// 	})

	// })

	const form = useForm(startData)

	let addingMemberModal = $state(false)
	let activeMember      = $state(null)

	//  Functions

    function submit(e) {
        e.preventDefault()
		if (faction) { updateFaction(faction.slug) }
		else           { createFaction() }
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

	function createFaction() {
		$form.post(route('factions.store'))
	}

	function updateFaction(slug) {
		$form.patch(route('factions.update', {faction: slug}))
	}

	function openMembershipModal(e, rel) {
		activeMember = rel
		addingMemberModal = true
	}

	function closeModal() {
		activeMember = null
		addingMemberModal = false
	}
	
</script>

<Form class="col-span-3 space-y-6">

	<!-- MAIN INFORMATION-->

	<Section class="space-y-6">

		<Heading is="h2" as="h5" class="mb-12"
			heading={faction ? "Edit Faction" : "New Faction"}
		/>

		<Field layout="block" inputClass="w-full"
			type="text"
			id="name"
			label="Name"
			description="The name of the faction."
			placeholder="Faction name"
			bind:value={$form.name}
			errors={$form.errors.name}
			required
		/>

		<Field layout="block" inputClass="w-full"
			type="textarea"
			id="description"
			label="Description"
			description="A detailed description of the faction."
			placeholder="Description..."
			bind:value={$form.description}
			errors={$form.errors.description}
			rows={5}
		/>

		<Field layout="block" inputClass="aspect-square h-72 w-72"
			type="file"
			id="emblem"
			label="Image"
			description="Upload a logo, icon, or sigil for this faction."
			icon="Image"
			placeholder="Upload an emblem..."
			preview={faction?.emblem?.url}
			bind:value={$form.emblem}
			errors={$form.errors.image}
		/>

	</Section>

	<!-- MEMBERS -->

	<Section>
		<Heading is="h3" as="h6" class="mb-6"
			heading="Members"
		/>
		<CardGrid cols={5}>
			{#each faction?.members as member, i}
				<Card aspect="square" class="w-full"
					icon="User"
					image={member.portrait?.url}
					title={member.name}
					subtitle={member.role}
					href={route('characters.show', {character: member.slug})}
				/>
			{/each}
			<CardNew aspect="square" class="w-full"
				onclick={openMembershipModal}
			/>
		</CardGrid>
	</Section>

	<!-- CUSTOM FIELDS -->

	<Section title="Custom Fields" class="space-y-6">
		{#each customFields as field, i}
			<Field
				type={field.type}
				id={getFieldName(field.name)}
				layout="block"
				inputClass="w-full"
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
		<!-- {#each project.custom_fields as field, i}
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
		{/each} -->
		
		<!-- <div class="pb-4">
			<h2 class="font-style-h6 text-slate-600 dark:text-slate-300">Custom fields</h2>
			<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
				To edit these Custom Fields, visit your <Link class="text-emerald-500 hover:underline" href={route('customfields')}>Project Settings</Link>.
			</p>
		</div> -->

		<!-- {#each project.custom_fields as field, i}
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
		{/each} -->
		
	</Section>
	
	<Section class="flex justify-center gap-3 w-full">
		<Button style="hard" theme="neutral"
			type="button"
			label="Cancel"
			onclick={() => history.back()}
		/>
		<Button style="hard" theme="accent"
			type="submit"
			label="{faction ? "Update" : "Create"} Faction"
			onclick={submit}
			disabled={!$form.isDirty || $form.processing || $form.recentlySuccessful}
		/>
	</Section>

</Form>

<Modal show={addingMemberModal} onclose={closeModal} class="flex items-start p-6">
	{#if addingMemberModal}
		TEST
		<!-- <FactionMemberForm faction={faction} member={activeMember} oncancel={closeModal} onsubmit={handleRelationship} /> -->
	{/if}
</Modal>