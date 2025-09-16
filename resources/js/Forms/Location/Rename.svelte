<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'
	import Modal  from '@/Components/UI/Modal.svelte'

    let {
		isOpen,
		location,
		oncancel = () => {},
	} = $props()

	const form = useForm({
		name: location?.name || ''
	});
</script>





<Modal title="Rename {location?.name}?"
	show={isOpen} maxWidth="lg" onclose={oncancel}>
	{#if location && location.slug}

		<Form
			class="max-w-lg"
			enctype="multipart/form-data"
			endpoint={route('locations.update', { location: location.slug})}
			form={form}
			method="patch"
			processing={$form.processing}
			recentlySuccessful={$form.recentlySuccessful}
			reloadPageProps={['locations', 'location']}
			onSuccess={oncancel}
		>
			<Stack class="p-3">
				<Field type="text"
					name="name"
					placeholder="New name"
					defaultValue={location?.name}
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
					label="Update"
				/>
			</Flex>

		</Form>
	{:else}

		<div class="p-3">
			<p class="font-style-placeholder">The form couldn't display correctly because no location entity was provided.</p>
		</div>

	{/if}
</Modal>