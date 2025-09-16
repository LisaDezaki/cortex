<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Button 	from '@/Components/UI/Button.svelte'
	import Icon 	from '@/Components/UI/Icon.svelte'
	import Modal  	from '@/Components/UI/Modal.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

    let {
		collection,
		isOpen,
		oncancel = () => {},
		...restProps
	} = $props()

	const form = useForm({});

</script>



<Modal title="Create Collection" show={isOpen} maxWidth="lg" onclose={oncancel}>
	{#if collection && collection.slug}
	
		<Form 
			class="max-w-lg"
			enctype="multipart/form-data"
			endpoint={route('collections.destroy', { collection: collection.slug})}
			form={form}
			method="delete"
			processing={$form.processing}
			reloadPageProps={['collections']}
			recentlySuccessful={$form.recentlySuccessful}
		{...restProps}>

			<Flex align="start" gap={6} class="mb-1.5 px-6 py-3">
				{#if collection && collection.image}
					<Thumbnail class="aspect-square w-20" src={collection.image?.url} />
				{:else}
					<Icon class="aspect-square bg-danger-softest my-1 p-2 rounded-full text-danger" name="Trash" size={24} />
				{/if}
				<Stack>
					<p>This process will remove this collection from the database, but it will not delete any of its items. <strong>Are you sure you want to delete this collection?</strong></p>
				</Stack>
			</Flex>
	
			<Flex gap={0} class="border-t flex-0 min-h-12">
				<Button style="hard" theme="neutral" class="border-none rounded-none w-1/2"
					type="button"
					label="No, Cancel"
					onclick={oncancel}
				/>
				<Button style="hard" theme="danger" class="border-none rounded-none w-1/2"
					type="submit"
					label="Yes, Delete this collection"
				/>
			</Flex>
	
		</Form>
	{:else}

		<p class="font-style-placeholder">The form couldn't display correctly because no Collection entity was provided.</p>
	
	{/if}
</Modal>
