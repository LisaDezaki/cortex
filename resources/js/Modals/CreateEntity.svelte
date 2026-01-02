<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Stack, UploadContext } from '@/Components/Core'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

    let {
		type,
		...restProps
	} = $props()

	const form = useForm({
		name:  '',
	})
</script>



<ModalForm
	size="md"
	form={form}
	method="post"
	submitProps={{
		label: 'Create'
	}}
	{...restProps}
>
	<Flex class="px-2">
		<Field type="text"
			name="name"
			placeholder="Name"
			required
		/>
	</Flex>
</ModalForm>