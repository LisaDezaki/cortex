<script>
	import { page } from '@inertiajs/svelte'

	import CustomFieldForm from '@/Forms/CustomField/CustomField.svelte'
	import { Flex, ReorderableList } from '@/Components/Core'
	import Button          from '@/Components/UI/Button.svelte'
	import DragHandle      from '@/Components/UI/DragHandle.svelte'
	import Heading         from '@/Components/UI/Heading.svelte'
	import Icon            from '@/Components/UI/Icon.svelte'
	import Modal           from '@/Components/UI/Modal.svelte'

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
	heading="Manage Custom Fields"
	subheading="Unlock the freedom of your mind."
/>

<ReorderableList items={customFields}>
	{#snippet itemTemplate(field, index)}
		<Flex gap={1.5} class="p-1 w-full">
			<DragHandle item={field} />
			<Flex align="center" gap={1.5} class="border border-neutral-softest px-2 rounded-md w-full">
				<Icon name={iconForType[field.type] || 'Question'} size={20} weight="light" class="text-emerald-500" />
				<span class="line-clamp-1 pb-0.5">{field.label}</span>
			</Flex>
			<Button
				style="soft" theme="accent"
				icon="Pen"
				onclick={() => editCustomField(index)}
			/>
			<Button
				style="soft" theme="danger"
				icon="Trash"
				onclick={deleteCustomField}
			/>
		</Flex>
	{/snippet}
</ReorderableList>

<Flex justify="center" class="mt-1">
	<Button
		style="soft" theme="accent"
		icon="Plus"
		label="Add a custom field"
		onclick={createCustomField}
	/>
</Flex>

<Modal
	title="{activeCustomField ? "Edit" : "Add"} Custom Field"
	show={showCustomFieldModal}
	onclose={closeModal}
>
	<CustomFieldForm
		field={activeCustomField}
		oncancel={closeModal}
	/>
</Modal>