<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'

    let {
		oncancel = () => {},
		project,
		...restProps
	} = $props()

	const form = useForm({
		name: ''
	});
</script>

{#if project && project.id}

	<Form
		class="max-w-lg"
		enctype="multipart/form-data"
		endpoint={route('projects.update', { project: project.id})}
		form={form}
		method="patch"
		processing={$form.processing}
		recentlySuccessful={$form.recentlySuccessful}
		reloadPageProps={['projects', 'project']}
	{...restProps}>

		<Stack class="p-3">
			<Field type="text"
				name="name"
				placeholder="New name"
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
			<Button style="hard" theme="accent" class="border-none rounded-none w-1/2"
				type="submit"
				label="Update"
			/>
		</Flex>

	</Form>

{:else}

	<div class="p-3">
		<p class="font-style-placeholder">The form couldn't display correctly because no Character entity was provided.</p>
	</div>

{/if}