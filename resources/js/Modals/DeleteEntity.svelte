<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Stack } from '@/Components/Core'
	import Icon		 from '@/Components/UI/Icon.svelte'
	import ModalForm	 from '@/Components/UI/ModalForm.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

    let {
		entity,
		entityName,
		...restProps
	} = $props()

	const form = useForm({});
</script>



<ModalForm title="Delete {entityName}: {entity?.name}" size="xl"
	form={form}
	method="delete"
	submitProps={{ text: 'Yes, Delete', theme: 'danger' }}
{...restProps}>
	<Flex align="center" gap={6} class="px-4">
		{#if entity && entity.image}
			<Thumbnail class="aspect-square rounded w-32" src={entity.image?.url} />
		{:else}
			<Icon class="aspect-square bg-danger-softest my-1 p-2 rounded-full text-danger" name="Trash" size={24} />
		{/if}
		<Stack gap={2}>
			<p>This process will remove this {entityName} and all associated data from the database.</p>
			<p><strong>Are you sure you want to delete this {entityName}?</strong></p>
		</Stack>
	</Flex>
</ModalForm>