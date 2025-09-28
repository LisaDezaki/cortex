<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Stack, UploadContext } from '@/Components/Core'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

    let {
	} = $props()

	const form = useForm({
		name:  '',
		alias: '',
		media: null
	})
</script>





<ModalForm title="Creating character" size="md"
	endpoint={route('characters.store')}
	form={form}
	method="post"
	submitProps={{
		label: 'Create'
	}}
>
	<Flex align="center" gap={3} class="px-6 pb-3">
		<UploadContext
			name="media"
			type="portrait"
			class="relative flex items-center justify-center shrink-0 bg-white border-b border-neutral-softer h-24 w-24 rounded-lg"
		/>
		<Stack gap={3} class="w-full">
			<Field type="text"
				name="name"
				placeholder="Character name"
				required
			/>
			<Field type="text"
				name="alias"
				placeholder="Character alias"
			/>
		</Stack>
	</Flex>
</ModalForm>