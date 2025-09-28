<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Stack }   from '@/Components/Core'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

    let {
		collection,
	} = $props()

	const form = useForm({
		name: collection?.name || ''
	});

</script>





<ModalForm title="Rename {collection?.name}?" size="sm"
	endpoint={route('collections.update', { collection: collection.slug})}
	form={form}
	method="patch"
	reloadPageProps={['collections']}
	submitProps={{
		label: 'Update'
	}}
>
	<Stack class="px-6 pb-3">
		<Field type="text"
			name="name"
			placeholder="New name"
			defaultValue={collection?.name}
			required
			autofocus
		/>
	</Stack>
</ModalForm>