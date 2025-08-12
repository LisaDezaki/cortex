<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field from '@/Components/UI/Field.svelte'

    let {
		oncancel = () => {},
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
	class="max-w-lg"
	enctype="multipart/form-data"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<Stack class="p-6">
		<p class="mb-4">Clicking 'Yes' will <strong>delete</strong> this location and all associated data. Are you <strong>absolutely</strong> sure you want to delete this location? </p>
	
		<p>Please type the name of the location ('<strong>{location.name}</strong>') to confirm deletion.</p>
	
		<Field type="text"
			id="confirm_name"
			label="Location name"
			bind:value={$form.confirm_name}
			errors={$form.errors.confirm_name}
			required
			autofocus
		/>
	</Stack>

	<Flex gap={0} class="border-t flex-0 min-h-12">
		<Button style="hard" theme="neutral" class="border-none rounded-none w-1/2"
			type="button"
			label="Cancel"
			onclick={oncancel}
		/>
		<Button style="hard" theme="danger" class="border-none rounded-none w-1/2"
			type="submit"
			label="Yes, Delete this location"
			onclick={deleteLocation}
		/>
	</Flex>

</Form>