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
		title,
		...restProps
	} = $props()

	const form = useForm({
		confirm_name: ''
	});

</script>



<ModalForm title={title || "Delete Project"} size="sm"
	endpoint={route('projects.destroy', { project: project.id })}
	form={form}
	method="delete"
	reloadPageProps={['projects']}
	submitProps={{ text: 'Yes, Delete ' + project.name, theme: 'danger' }}
{...restProps}>

	<Stack gap={3} class="px-4 pb-3">

		<Media
			class="aspect-[7/3] bg-neutral-softest rounded-md w-full"
			icon="GlobeStand"
			media={project.image}
		/>

		<p class="font-style-small">Are you sure you want to delete the {project.name} project?</p>
		<p class="font-style-small">This process will remove this project and all associated data from the database.</p>
		<p class="font-style-small">Please type the name of the project ("<strong>{project.name}</strong>") to confirm deletion.</p>
		
		<Field type="text"
			name="confirm_name"
			placeholder={project.name}
			required
			autofocus
		/>

	</Stack>

</ModalForm>