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
	<Form.Field>
		<Form.Label for="image" value="Image" />
		<Form.Upload
			id="image"
			bind:value={$updateForm.image}
			class="aspect-[5/2]"
		/>
		<Form.Error message={$updateForm.errors.image} />
	</Form.Field>

	<Form.Field>
		<Form.Label for="name" value="Name" />
		<Form.Input
			id="name"
			type="text"
			bind:value={$updateForm.name}
			required
			autofocus
			autocomplete="name"
		/>
		<Form.Error message={$updateForm.errors.name} />
	</Form.Field>

	<Form.Field>
		<Form.Label for="description" value="Description" />
		<Form.Textarea
			id="description"
			bind:value={$updateForm.description}
			rows={5}
		/>
		<Form.Error message={$updateForm.errors.description} />
	</Form.Field>

	{#snippet actions()}
		<Button secondary label="Cancel"       type="button" onclick={oncancel} />
		<Button primary   label="Update project" type="submit" onclick={submit} />
	{/snippet}

</Form>