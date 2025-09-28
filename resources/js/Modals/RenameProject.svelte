<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

    let {
		project,
		...restProps
	} = $props()

	const form = useForm({
		name: project.name,
		type: project.type
	});
</script>





<ModalForm title="Renaming Project" size="sm"
	endpoint={route('projects.update', { project: project.id})}
	form={form}
	method="patch"
	reloadPageProps={['projects', 'project']}
	submitProps={{ label: 'Update' }}
{...restProps}>
	<Stack gap={2} class="px-4 py-3 pt-0">
		<Field type="text"
			name="name"
			placeholder="New name"
			required
			autofocus
		/>
		<Field type="text"
			name="type"
			placeholder="Project type"
		/>
	</Stack>
</ModalForm>