<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form'

    let { oncancel, project } = $props()

	const updateForm = useForm({
		image: project.image,
        name: project.name,
        description: project.description,
		_method: 'patch',
    })

    function submit(e) {
        e.preventDefault();
		$updateForm.post(route('projects.update', { project: project.id}), {
			onSuccess: () => {
				oncancel();
			}
		});
    }

	const deleteForm = useForm({});
	function deleteProject(e) {
		e.preventDefault();
		$deleteForm.delete(route('projects.destroy', { project: project.id}) );
	}

</script>

<Form
	class="space-y-3"
	title="Update Project"
	enctype="multipart/form-data"
	processing={$updateForm.processing}
	recentlySuccessful={$updateForm.recentlySuccessful}
>
	<Form.Field
		id="image"
		type="file"
		label="Image"
		bind:value={$updateForm.image}
		errors={$updateForm.errors.image}
	/>

	<Form.Field required autofocus
		id="name"
		type="text"
		label="Name"
		bind:value={$updateForm.name}
		errors={$updateForm.errors.name}
	/>

	<Form.Field rows={5}
		id="description"
		type="textarea"
		label="Description"
		bind:value={$updateForm.description}
		errors={$updateForm.errors.description}
	/>

	{#snippet actions()}
		<Button style="hard" theme="neutral"
			label="Cancel"
			type="button"
			onclick={oncancel}
		/>
		<Button style="hard" theme="accent"
			label="Update project"
			type="submit"
			onclick={submit}
		/>
	{/snippet}

</Form>