<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Stack }   from '@/Components/Core'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm from '@/Components/UI/ModalForm.svelte'

    let {
		type,
	} = $props()

	const form = useForm({
		collection_type: type,
		name: '',
	});

</script>





<ModalForm title="Creating Collection" size="sm"
	endpoint={route('collections.store')}
	form={form}
	method="post"
	reloadPageProps={['collections']}
	submitProps={{
		label: 'Create'
	}}
>
	<Stack class="px-3 pb-3">
		<Field type="text"
			name="name"
			placeholder="Collection name"
			required
		/>
	</Stack>
</ModalForm>