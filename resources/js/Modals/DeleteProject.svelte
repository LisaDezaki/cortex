<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'
	
	import { Flex, Form, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'
	import Media  from '@/Components/UI/Media.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

    let {
		isOpen = false,
		project,
		...restProps
	} = $props()

	const form = useForm({
		confirm_name: ''
	});

</script>





<ModalForm title="Delete Project?" size="lg"
	endpoint={route('projects.destroy', { project: project.id })}
	form={form}
	method="delete"
	reloadPageProps={['projects']}
	submitProps={{ label: 'Yes, Delete', theme: 'danger' }}
{...restProps}>

	<Stack class="px-6 py-3">

		<Media
			aspect="aspect-[7/3]"
			class="bg-neutral-softest mb-3 rounded-md w-full"
			icon="GlobeStand"
			media={project.image}
		/>

		<p class="mx-3 text-sm">Please type the name of the project ("<strong>{project.name}</strong>") to confirm deletion.</p>
	
		<Field type="text"
			name="confirm_name"
			placeholder={project.name}
			required
			autofocus
		/>

		<p class="m-3 text-sm text-danger">This process will remove this project and all associated data from the database. Are you sure you want to delete this project?</p>

	</Stack>

</ModalForm>