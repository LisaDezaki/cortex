<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'

    let {
		collection,
		...restProps
	} = $props()

	const form = useForm({
		confirm_name: ''
	});

</script>





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
		<Stack gap={3} class="p-6">
			<p class="text-neutral">This process will remove this collection from the database, but it will not delete any of its items.</p>
			<p class="text-danger">Are you sure you want to delete this collection?</p>
		</Stack>

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