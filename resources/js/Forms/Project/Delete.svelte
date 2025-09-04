<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'
	
	import { Flex, Form, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'

    let {
		oncancel = () => {},
		project
	} = $props()

	const form = useForm({
		confirm_name: ''
	});

</script>

<Form
	class="max-w-lg"
	enctype="multipart/form-data"
	endpoint={route('projects.destroy', { project: project.id})}
	form={form}
	method="delete"
	reloadPageProps={['locations']}
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<Stack align="center" class="px-6 py-3">
		<Icon name="List" />
		<p>This process will also delete all data associated with the project. Are you absolutely sure you want to delete the entire project? </p>
	</Stack>

	<Flex gap={0} class="border-t flex-0 min-h-12">
		<Button style="hard" theme="neutral" class="border-none rounded-none w-1/2"
			type="button"
			label="Cancel"
			onclick={oncancel}
		/>
		<Button style="hard" theme="danger" class="border-none rounded-none w-1/2"
			type="submit"
			label="Yes, Delete this project"
		/>
	</Flex>

</Form>