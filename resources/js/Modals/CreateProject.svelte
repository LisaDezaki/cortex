<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Stack, UploadContext } from '@/Components/Core'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

	const form = useForm({
		name: '',
		type: '',
		media: null
	});
</script>





<ModalForm title="Create a new project" size="lg"
	endpoint={route('projects.store')}
	form={form}
	method="post"
	reloadPageProps={['projects']}
	submitProps={{ label: 'Create' }}
>
	<Flex align="center" gap={3} class="px-6 py-3">
		<UploadContext
			name="media"
			type="banner"
			class="relative flex items-center justify-center shrink-0 bg-white border-b border-neutral-softer h-24 w-24 rounded-lg"
		/>
		<Stack gap={3} class="w-full">
			<Field type="text"
				name="name"
				placeholder="Project name"
				required
			/>
			<Field type="text"
				name="type"
				placeholder="Project type"
			/>
		</Stack>
	</Flex>
</ModalForm>