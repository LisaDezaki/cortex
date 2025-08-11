<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import Field from '@/Components/Field.svelte'
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
	class="max-w-lg"
	enctype="multipart/form-data"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<div class="p-6">
		<p>This process will also delete all data associated with the project. Are you absolutely sure you want to delete the entire project? </p>
	
		<Field class="my-3"
			id="confirm_name"
			type="text"
			bind:value={$form.confirm_name}
			errors={$form.errors.confirm_name}
			required autofocus
		/>
	
		<p>Please type the name of the project ("<strong>{project.name}</strong>") to confirm deletion.</p>
	</div>

	<div class="border-t flex items-center justify-end gap-1.5 p-1.5">
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
	</div>

</Form>