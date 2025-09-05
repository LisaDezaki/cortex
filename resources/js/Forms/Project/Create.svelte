<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'

    let {
		oncancel = () => {},
		...restProps
	} = $props()

	const form = useForm({
		name: '',
		type: '',
		description: '',
	});
</script>





<Form
	class="max-w-lg"
	enctype="multipart/form-data"
	endpoint={route('projects.store')}
	form={form}
	method="post"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
	reloadPageProps={['projects']}
{...restProps}>

	<Stack gap={1.5} class="p-3">
		<p class="mx-1.5">Give the new project a name</p>
		<Field type="text"
			name="name"
			placeholder="Name"
			required
			autofocus
		/>
		<p class="mx-1.5">What kind of project is this?</p>
		<Field type="text"
			name="type"
			placeholder="Type"
		/>
		<Field type="textarea"
			name="description"
			placeholder="Project description"
			rows={3}
		/>
	</Stack>

	<Flex gap={0} class="border-t flex-0 min-h-12">
		<Button style="hard" theme="neutral" class="border-none rounded-none w-1/2"
			type="button"
			label="Cancel"
			onclick={oncancel}
		/>
		<Button style="hard" theme="accent" class="border-none rounded-none w-1/2"
			type="submit"
			label="Create"
		/>
	</Flex>

</Form>