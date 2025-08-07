<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form.svelte'
	import Field from '@/Components/Field.svelte'

    let {
		oncancel = () => {},
		character
	} = $props()

	const form = useForm({
		confirm_name: ''
	});
	function deleteCharacter(e) {
		e.preventDefault();
		$form.delete(route('characters.destroy', { character: character.slug}), {
			onSuccess: () => {
				oncancel();
			}
		} );
	}

</script>

<Form
	class="form-styles space-y-3"
	title="Are you sure you want to delete {character.name}?"
	enctype="multipart/form-data"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<p class="mb-4">This process will remove this character and all associated data from the database. Are you sure you want to delete this character? </p>

	<p>Please type the name of the character ("<strong>{character.name}</strong>") to confirm deletion.</p>

	<Form.Field>
		<Form.Label for="confirm_name" value="Character name" />
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
		<Button style="hard" theme="neutral"
			type="button"
			label="Cancel"
			onclick={oncancel}
		/>
		<Button style="hard" theme="danger"
			type="submit"
			label="Yes, Delete this character"
			onclick={deleteCharacter}
		/>
	{/snippet}

</Form>