<script>
    import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import {
		Flex, Form,
		UploadContext,
		UploadPreview,
		UploadTrigger
	} from '@/Components/Core'

	import Button  from '@/Components/UI/Button.svelte'
	import Field   from '@/Components/UI/Field.svelte'
	import Section from '@/Components/UI/Section.svelte'

    let {
		oncancel = () => {},
		project
	} = $props()

	// const form = useForm({
	// 	banner: project?.banner?.path || null,
    //     name: project?.name || null,
    //     description: project?.description || null,
    // });
	// const deleteForm = useForm({});

    // function submit(e) {
    //     e.preventDefault();
	// 	if (project) { updateProject() }
	// 	else         { createProject() }
    // }

	// function createProject() {
	// 	$form.post(route('projects.store'), {
	// 		onSuccess: () => {
	// 			oncancel();
	// 		}
	// 	})
	// }
	// function updateProject() {
	// 	$form.patch(route('projects.update', {project: project.id}), {
	// 		onSuccess: () => {
	// 			oncancel();
	// 		}
	// 	})
	// }
	// function deleteProject(e) {
	// 	e.preventDefault();
	// 	$deleteForm.delete(route('projects.destroy', { project: project.id}) );
	// }

</script>

<Form
	enctype="multipart/form-data"
	endpoint={project ? route('projects.update', {project: project.id}) : route('projects.store')}
	method={project ? 'patch' : 'post'}
	initialData={{
		banner: project?.banner?.path || null,
        name: project?.name || null,
        description: project?.description || null,
	}}

>
	<div class="w-[80vh] max-w-2xl">

		<UploadContext name="banner" preview={project.banner?.url} class="border-b aspect-[21/9] relative w-full">
			<UploadPreview class="flex items-center justify-center h-full w-full">
				<UploadTrigger icon="Image" label="Upload banner" />
			</UploadPreview>
		</UploadContext>
	
		<Section class="p-6">
		
			<Field name="name" class="w-1/2"
				type="text" 
				label="Name"
				description="Give this project a short, memorable name."
				required
				autofocus
			/>
		
			<Field name="description"
				type="textarea"
				label="Description"
				rows={5}
			/>
		</Section>
	</div>


	<Flex gap={3} class="p-3">
		<Button style="soft" theme="neutral" class="rounded-full"
			type="button"
			icon="X"
			onclick={oncancel}
		/>
		<Button style="soft" theme="accent" class="rounded-full"
			type="submit"
			icon="Check"
		/>
	</Flex>

</Form>