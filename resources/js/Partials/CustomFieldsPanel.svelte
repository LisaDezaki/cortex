<script>
	import { page } from '@inertiajs/svelte'

	import CustomFieldForm from '@/Forms/CustomFieldForm.svelte'
	import Article from '@/Components/Article.svelte'
	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form'
	import Heading from '@/Components/Heading.svelte'
	import Icon from '@/Components/Icon.svelte'
	import Modal from '@/Components/Modal.svelte'

	let project = $page.props.active_project.data
	let characters = project?.characters
	let custom_fields = project?.custom_fields.filter(f => f.entity === 'character')

	let creatingCharacter = $state(false)
	let query             = $state('')
	let filteredCharacters = $state(characters)
	let showCustomFieldModal = $state(false)
	let activeCustomFieldIndex = $state(null)
	let activeCustomField = $derived(custom_fields[activeCustomFieldIndex] || null)

	let iconForType = {
		text: 'TextAa',
		number: 'Hash',
		link: 'Link',
		switch: 'ToggleRight',
		select: 'RowsPlusBottom',
		entity: 'Table',
		upload: 'ImageSquare'
	}

	function createCharacter() {
		activeCustomFieldIndex = null
        creatingCharacter = true
    }
	function createCustomField() {
		activeCustomFieldIndex = null
		showCustomFieldModal = true
	}
	function editCustomField(index) {
		activeCustomFieldIndex = index;
		showCustomFieldModal = true;
	}
	function closeModal() {
		activeCustomFieldIndex = null
		creatingCharacter = false
		showCustomFieldModal = false
    }

	function filterCharacters(e) {
		filteredCharacters = query.length == 0
			? characters
			: characters.filter(c => {
				let string = `${c.name} ${c.alias}`;
				return string.toLowerCase().includes(e.target.value.toLowerCase());
			})
	}

</script>

<Heading is="h4" as="h6"
	heading="Custom Fields"
	subheading="Manage your custom fields here."
/>

<div class="flex flex-col items-center">
	{#each custom_fields as field, i}
		<div class="flex items-center gap-3 w-full border-b p-1">
			<div class="flex-shrink-0 flex items-center aspect-ratio bg-slate-500/10 rounded-lg p-1">
				<Icon name={iconForType[field.type] || 'Question'} size={24} class="text-slate-500" />
			</div>
			<div class="w-full">{field.name}</div>
			<div class="col-span-1 flex justify-end gap-0.5">
				<Button
					plain
					class="bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-500 rounded"
					icon="Pen"
					onclick={() => editCustomField(i)}
				/>
				<Button
					plain
					class="bg-rose-500/15 hover:bg-rose-500/25 text-rose-500 rounded"
					icon="Trash"
					onclick={createCustomField}
				/>
			</div>
		</div>
	{/each}
	<Button
		plain
		class="bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-500 rounded-lg font-style-button mt-1.5"
		icon="Plus"
		label="Add a custom field"
		onclick={createCustomField}
	/>
</div>

<Modal show={showCustomFieldModal} onclose={closeModal}>
	<CustomFieldForm data={activeCustomField} oncancel={closeModal} />
</Modal>