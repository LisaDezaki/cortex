<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Stack }   from '@/Components/Core'
	import Icon 	 from '@/Components/UI/Icon.svelte'
	import ModalForm from '@/Components/UI/ModalForm.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

    let {
		collection
	} = $props()

	const form = useForm({});

</script>



<ModalForm title="Delete Collection" size="md"
	endpoint={route('collections.destroy', { collection: collection.slug})}
	form={form}
	method="delete"
	reloadPageProps={['collections']}
	submitProps={{
		label: 'Yes, Delete',
		theme: 'danger'
	}}
>
	<Flex align="start" gap={6} class="mb-1.5 px-6 pb-3">
		{#if collection && collection.image}
			<Thumbnail class="aspect-square w-20" src={collection.image?.url} />
		{:else}
			<Icon class="aspect-square bg-danger-softest my-1 p-2 rounded-full text-danger" name="Trash" size={24} />
		{/if}
		<Stack gap={2}>
			<p>This process will remove this collection from the database, but it will not delete any of its items.</p>
			<p><strong>Are you sure you want to delete this collection?</strong></p>
		</Stack>
	</Flex>
</ModalForm>
