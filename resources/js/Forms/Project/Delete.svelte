<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'
	
	import { Flex, Form, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'
	import Media  from '@/Components/UI/Media.svelte'
	import Modal  from '@/Components/UI/Modal.svelte'

    let {
		isOpen = false,
		oncancel = () => {},
		project,
		...restProps
	} = $props()

	const form = useForm({
		confirm_name: ''
	});

</script>





<Modal title="Delete Project"
	maxWidth="lg" show={isOpen} onclose={oncancel}>
	{#if project && project.id}

		<Form
			class="max-w-lg"
			enctype="multipart/form-data"
			endpoint={route('projects.destroy', { project: project.id})}
			form={form}
			method="delete"
			processing={$form.processing}
			recentlySuccessful={$form.recentlySuccessful}
			reloadPageProps={['projects']}
		{...restProps}>

			<Stack class="p-3">

				<pre class="text-xs">{JSON.stringify(project.media,null,3)}</pre>

				<Media
					aspect="aspect-[7/3]"
					class="bg-neutral-softest mb-3 rounded-md w-full"
					icon="GlobeStand"
					media={project.image}
				/>

				<p class="mx-3 text-sm">Please type the name of the project ("<strong>{project.name}</strong>") to confirm deletion.</p>
			
				<Field type="text"
					name="confirm_name"
					placeholder={project.name}
					required
					autofocus
				/>

				<p class="m-3 text-sm text-danger">This process will remove this project and all associated data from the database. Are you sure you want to delete this project?</p>

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

	{/if}

</Modal>