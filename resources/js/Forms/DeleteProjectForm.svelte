<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form.svelte'

    let {
		oncancel = () => {},
		project
	} = $props()

	const form = useForm({
		confirm_name: ''
	});
	function deleteProject(e) {
		e.preventDefault();
		$form.delete(route('projects.destroy', { project: project.id}) );
	}

</script>

<Form
	class="space-y-3"
	title="Delete Project?"
	enctype="multipart/form-data"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<p>This process will also delete all data associated with the project. Are you absolutely sure you want to delete the entire project? </p>

	<Form.Field required autofocus
		id="confirm_name"
		type="text"
		bind:value={$form.confirm_name}
		errors={$form.errors.confirm_name}
	/>

	<p>Please type the name of the project ("<strong>{project.name}</strong>") to confirm deletion.</p>

	{#snippet actions()}
		<Button style="hard" theme="neutral"
			type="button"
			label="Cancel"
			onclick={oncancel}
		/>
		<Button style="hard" theme="danger"
			type="submit"
			label="Yes, Delete this project"
			onclick={deleteProject}
		/>
	{/snippet}

</Form>