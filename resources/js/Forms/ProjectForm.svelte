<script>
    import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form.svelte'

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

<Form
	class="space-y-3"
	enctype="multipart/form-data"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
	title={project ? "Edit Project" : "Create Project"}
>

	<!-- <pre>{JSON.stringify($form,null,4)}</pre> -->

	<Form.Field
		id="image"
		type="file"
		label="Image"
		layout="block"
		bind:value={$form.banner}
		preview={project?.banner?.url}
		errors={$form.errors.banner}
		inputClass="h-24 w-48"
	/>

	<Form.Field required autofocus
		id="name"
		type="text"
		label="Name"
		layout="block"
		bind:value={$form.name}
		errors={$form.errors.name}
	/>

	<Form.Field rows={5}
		id="description"
		type="textarea"
		label="Description"
		layout="block"
		bind:value={$form.description}
		errors={$form.errors.description}
	/>

	{#snippet actions()}
		<Button style="hard" theme="neutral"
			label="Cancel"
			type="button"
			onclick={oncancel}
		/>
		<Button style="hard" theme="accent"
			label={project ? "Update project" : "Create project"}
			type="submit"
			onclick={submit}
		/>
	{/snippet}

</Form>