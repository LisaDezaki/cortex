<script>
	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Article from '@/Components/Article.svelte'
	import Button from '@/Components/Button.svelte'
	import Card from '@/Components/Card.svelte'
	// import FactionCard from '@/Components/FactionCard.svelte'
	import Form from '@/Components/Form'

	//  Props

	let project = $page.props.active_project.data
	let { faction } = $props()

	//  Form

	let startData = {
		image: faction?.image || null,
        name: faction?.name || null,
        description: faction?.description || null,
		custom_fields: faction?.custom_fields || []
	}

	//  Process the custom fields and make sure they are
	//  populated correctly if the faction is being edited
	// project?.custom_fields?.forEach((field) => {

	// 	//  Generate a field name that is safe for use in JavaScript
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
	
</script>

<!-- <pre>{JSON.stringify(faction, null, 4)}</pre> -->

<Form class="col-span-3 space-y-6">

	<!-- MAIN INFORMATION-->

	<Article
		title={faction ? "Edit Faction" : "New Faction"}
		subtitle={faction ? "Edit this faction's details." : "Build a new faction to add to the " + project.name + " project."}
		bodyclass="space-y-6 px-6"
	>
		<!-- FORM.MAIN -->

		<Form.Field
			type="file"
			id="image"
			layout="block"
			class="w-full"
			bind:value={$form.image}
			previewPath={faction?.image_path}
			description="Upload a logo, icon, or sigil for this faction."
			errors={$form.errors.image}
			label="Image"
		/>

		<Form.Field
			type="text"
			id="name"
			layout="block"
			class="w-full"
			bind:value={$form.name}
			description="The name of the faction."
			errors={$form.errors.name}
			label="Name"
			required
		/>

		<Form.Field
			type="textarea"
			id="description"
			layout="block"
			bind:value={$form.description}
			description="A detailed description of the faction."
			errors={$form.errors.description}
			label="Description"
			rows={8}
		/>
	</Article>

	<!-- Members -->

	<Article
		title="Members"
		subtitle="Characters that are members of this faction."
		bodyclass="grid grid-cols-6 gap-2 px-6"
	>
		{#each faction?.members as member, i}
			<Card
				class="aspect-[3/4]"
				title={member.name}
				subtitle={member.role}
				image={member.image_path}
				href={route('characters.show', {character: member.slug})}
			/>
		{/each}
	</Article>

	<!-- CUSTOM FIELDS -->

	<Article
		title="Custom Fields"
		subtitle="To edit these Custom Fields, visit your Project Settings."
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
		
		<!-- <div class="pb-4">
			<h2 class="font-style-h6 text-slate-600 dark:text-slate-300">Custom fields</h2>
			<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
				To edit these Custom Fields, visit your <Link class="text-emerald-500 hover:underline" href={route('customfields')}>Project Settings</Link>.
			</p>
		</div> -->

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
		
	</Article>
	
</Form>

<div class="col-span-2">
	<div class="flex gap-3 w-full">
		<Button
			class="w-full"
			type="submit"
			primary={$form.isDirty}
			disabled={!$form.isDirty || $form.processing || $form.recentlySuccessful}
			label="{faction ? "Update" : "Create"} Faction"
			onclick={submit}
		/>
		<Button
			type="button"
			secondary
			label="Cancel"
			onclick={() => history.back()}
		/>
	</div>
</div>