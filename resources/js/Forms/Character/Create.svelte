<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'

    let {
		oncancel = () => {},
	} = $props()

	const form = useForm({
		name: '',
		description: '',
	});
</script>





<Form
	class="max-w-lg"
	enctype="multipart/form-data"
	endpoint={route('characters.store')}
	form={form}
	method="post"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
	onFinish={oncancel}
>
	<Stack class="p-3">
		<Field type="text"
			name="name"
			placeholder="Character name"
			required
			autofocus
		/>
		<Field type="textarea"
			name="description"
			placeholder="Character description"
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