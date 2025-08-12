<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'

    let {
		oncancel = () => {},
		faction
	} = $props()

	const form = useForm({
		confirm_name: ''
	});
	function deleteFaction(e) {
		e.preventDefault();
		$form.delete(route('factions.destroy', { faction: faction.slug}), {
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
		<p class="mb-4">Clicking 'Yes' will <strong>delete</strong> this faction and all associated data. Are you <strong>absolutely</strong> sure you want to delete this faction? </p>
	
		<p>Please type the name of the faction ('<strong>{faction.name}</strong>') to confirm deletion.</p>
	
		<Field type="text"
			id="confirm_name"
			label="Faction name"
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
			label="Yes, Delete this faction"
			onclick={deleteFaction}
		/>
	</Flex>

</Form>