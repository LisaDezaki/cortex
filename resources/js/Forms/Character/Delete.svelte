<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'

    let {
		oncancel = () => {},
		character
	} = $props()

	const form = useForm({
		confirm_name: ''
	});

</script>

<Form
	class="max-w-lg"
	enctype="multipart/form-data"
	endpoint={route('characters.destroy', { character: character.slug})}
	form={form}
	method="delete"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<Stack class="p-6">
		<p class="mb-3">This process will remove this character and all associated data from the database. Are you sure you want to delete this character?</p>
	
		<p>Please type the name of the character ("<strong>{character.name}</strong>") to confirm deletion.</p>
	
		<Field type="text"
			name="confirm_name"
			label="Character name"
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
			label="Yes, Delete this character"
		/>
	</Flex>

</Form>