<script>
	import { page } from '@inertiajs/svelte'

	import CustomFieldForm from '@/Forms/CustomFieldForm.svelte'
	import Button from '@/Components/Button.svelte'
	import DragHandle from '@/Components/DragHandle.svelte'
	import Heading from '@/Components/Heading.svelte'
	import Icon from '@/Components/Icon.svelte'
	import Modal from '@/Components/Modal.svelte'
	import ReorderableList from '@/Components/ReorderableList.svelte'

	const customFields = $page.props.customFields?.data

	let showCustomFieldModal = $state(false)
	let activeCustomFieldIndex = $state(null)
	let activeCustomField = $derived(customFields?.[activeCustomFieldIndex] || null)

	let iconForType = {
		text:   'TextAa',
		number: 'Hash',
		link:   'Link',
		switch: 'ToggleRight',
		select: 'RowsPlusBottom',
		entity: 'Table',
		upload: 'ImageSquare'
	}

	function createCustomField() {
		activeCustomFieldIndex = null
		showCustomFieldModal = true
	}
	function editCustomField(index) {
		activeCustomFieldIndex = index;
		showCustomFieldModal = true;
	}
	function deleteCustomField(index) {
		activeCustomFieldIndex = index;
		// showCustomFieldModal = true;
	}
	function closeModal() {
		activeCustomFieldIndex = null
		showCustomFieldModal = false
    }

</script>

<Heading is="h4" as="h6" class="mb-6"
	heading="Custom Fields"
	subheading="Manage your custom fields here."
/>

<ReorderableList items={customFields}>
	{#snippet itemTemplate(field)}
		<div class="flex gap-1.5 w-full p-1">
			<div class="flex items-center">
				<DragHandle item={field} />
			</div>
			<div class="border border-slate-500/15 flex items-center gap-1.5 px-2 w-full rounded-md">
				<Icon name={iconForType[field.type] || 'Question'} size={20} weight="light" class="text-emerald-500" />
				<span class="line-clamp-1 pb-0.5">{field.label}</span>
			</div>
			<div class="col-span-1 flex justify-end gap-0.5">
				<Button
					style="soft" theme="accent"
					icon="Pen"
					onclick={() => editCustomField(i)}
				/>
				<Button
					style="soft" theme="danger"
					icon="Trash"
					onclick={deleteCustomField}
				/>
			</div>
		</div>
	{/snippet}
</ReorderableList>

<div class="flex flex-col items-center">
	<Button
		style="soft" theme="accent"
		class="bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-500 rounded-lg font-style-button mt-1.5"
		icon="Plus"
		label="Add a custom field"
		onclick={createCustomField}
	/>
</div>

<Modal show={showCustomFieldModal} onclose={closeModal}>
	<CustomFieldForm data={activeCustomField} oncancel={closeModal} />
</Modal>