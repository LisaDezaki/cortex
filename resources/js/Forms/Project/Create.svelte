<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'
	import Modal  from '@/Components/UI/Modal.svelte'

    let {
		isOpen = false,
		oncancel = () => {},
		...restProps
	} = $props()

	const form = useForm({
		name: '',
	});
</script>





<Modal title="Create a new project"
	show={isOpen} maxWidth="lg" onclose={oncancel}>
	
	<Form
		class="max-w-lg"
		enctype="multipart/form-data"
		endpoint={route('projects.store')}
		form={form}
		method="post"
		processing={$form.processing}
		recentlySuccessful={$form.recentlySuccessful}
		reloadPageProps={['projects']}
		onFinish={oncancel}
	{...restProps}>

		<Stack class="p-3">
			<Field type="text"
				name="name"
				placeholder="Name"
				required
				autofocus
			/>
		</Stack>

		<Flex gap={0} class="border-t flex-0 min-h-12">
			<Button style="hard" theme="neutral"
				class="border-none rounded-none w-1/2"
				type="button"
				label="Cancel"
				onclick={oncancel}
			/>
			<Button style="hard" theme="accent"
				class="border-none rounded-none w-1/2"
				type="submit"
				label="Create"
			/>
		</Flex>

	</Form>
</Modal>