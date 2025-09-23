<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm from '@/Components/UI/ModalForm.svelte'

    let {
		type,
		entity,
	} = $props()

	const form = useForm({
		collection_type: type,
		name: '',
	});

</script>





<ModalForm title="Create Collection" size="lg"
	endpoint={route('collections.store')}
	form={form}
	method="post"
	reloadPageProps={['collections']}
	submitProps={{
		label: 'Create'
	}}
>
	<Stack class="px-6 py-3">
		<Field type="text"
			name="name"
			placeholder="Collection name"
			required
		/>
	</Stack>
</ModalForm>