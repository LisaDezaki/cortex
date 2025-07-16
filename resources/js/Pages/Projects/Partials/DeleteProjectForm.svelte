<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form'

    let { oncancel, project } = $props()

	const form = useForm({
		confirm_name: ''
	});
	function deleteProject(e) {
		e.preventDefault();
		$form.delete(route('projects.destroy', { project: project.id}) );
	}

</script>

<Form
	title="Delete Project?"
	enctype="multipart/form-data"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<p class="mb-4">This process will also delete all data associated with the project. Are you absolutely sure you want to delete the entire project? </p>

	<p>Please type the name of the project to confirm deletion.</p>

	<Form.Field>
		<Form.Label for="confirm_name" value="Project name" />
		<Form.Input
			id="confirm_name"
			type="text"
			bind:value={$form.confirm_name}
			required
			autofocus
		/>
		<Form.Error message={$form.errors.confirm_name} />
	</Form.Field>

	{#snippet actions()}
		<Button secondary label="Cancel"      type="button" onclick={oncancel} />
		<Button danger    label="Yes, Delete this project" type="button" onclick={deleteProject}  />
	{/snippet}

</Form>