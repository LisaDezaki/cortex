<script>
    import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import UploadContext from '@/Components/Util/UploadContext.svelte'
	import UploadPreview from '@/Components/Util/UploadPreview.svelte'
	import UploadTrigger from '@/Components/Util/UploadTrigger.svelte'

	import Button from '@/Components/Button.svelte'
	import Field from '@/Components/Field.svelte'
	import Form from '@/Components/Form.svelte'
	import Section from '@/Components/Section.svelte'

    let {
		oncancel = () => {},
		project
	} = $props()

	const form = useForm({
		banner: project?.banner?.id || null,
        name: project?.name || null,
        description: project?.description || null,
    });
	const deleteForm = useForm({});

    function submit(e) {
        e.preventDefault();
		if (project) { updateProject() }
		else         { createProject() }
    }

	function createProject() {
		$form.post(route('projects.store'), {
			onSuccess: () => {
				oncancel();
			}
		})
	}
	function updateProject() {
		$form.patch(route('projects.update', {project: project.id}), {
			onSuccess: () => {
				oncancel();
			}
		})
	}
	function deleteProject(e) {
		e.preventDefault();
		$deleteForm.delete(route('projects.destroy', { project: project.id}) );
	}

</script>

<!-- <pre>{JSON.stringify(project.banner,null,4)}</pre> -->

<!-- <FlexH x="center" y="top" /> -->

<Form
	enctype="multipart/form-data"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<div class="w-[80vh] max-w-2xl">
		<UploadContext class="border-b aspect-[21/9] relative w-full">
			<UploadPreview class="flex items-center justify-center h-full w-full">
				<UploadTrigger icon="Image" label="Upload banner" />
			</UploadPreview>
		</UploadContext>
	
		<Section class="p-6">
		
			<Field type="text" id="name"
				class="w-1/2"
				label="Name"
				description="Give this project a short, memorable name."
				bind:value={$form.name}
				errors={$form.errors.name}
				required
				autofocus
			/>
		
			<Field type="textarea" id="description"
				label="Description"
				bind:value={$form.description}
				errors={$form.errors.description}
				rows={5}
			/>
		</Section>
	</div>


	<div class="border-t flex items-center justify-end min-h-12">
		<Button style="hard" theme="neutral" class="border-none h-12 rounded-none"
			label="Cancel"
			type="button"
			onclick={oncancel}
		/>
		<Button style="hard" theme="accent" class="border-none h-12 rounded-none"
			label={project ? "Update project" : "Create project"}
			type="submit"
			onclick={submit}
		/>
	</div>

</Form>