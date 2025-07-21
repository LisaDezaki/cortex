<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form'

    let {
		oncancel,
		location
	} = $props()

	const form = useForm({
		confirm_name: ''
	});
	function deleteLocation(e) {
		e.preventDefault();
		$form.delete(route('locations.destroy', { location: location.slug}), {
			onSuccess: () => {
				oncancel();
			}
		} );
	}

</script>

<Form
	class="form-styles space-y-3"
	title="Delete {location.name}?"
	enctype="multipart/form-data"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<p class="mb-4">Clicking 'Yes' will <strong>delete</strong> this location and all associated data. Are you <strong>absolutely</strong> sure you want to delete this location? </p>

	<p>Please type the name of the location ('<strong>{location.name}</strong>') to confirm deletion.</p>

	<Form.Field>
		<Form.Label for="confirm_name" value="Location name" />
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
			label="Yes, Delete this location"
			onclick={deleteLocation}
		/>
	{/snippet}

</Form>