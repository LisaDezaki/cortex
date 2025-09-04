<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'

    let {
		oncancel = () => {},
		location
	} = $props()

	const form = useForm({
		confirm_name: ''
	});

</script>





{#if location && location.slug}

	<Form
		class="max-w-lg"
		enctype="multipart/form-data"
		endpoint={route('locations.destroy', { location: location.slug})}
		form={form}
		method="delete"
		reloadPageProps={['locations']}
		processing={$form.processing}
		recentlySuccessful={$form.recentlySuccessful}
	>
		<Stack align="center" class="p-6" gap={3}>
			<Flex justify="center" class="">
				<Icon class="bg-danger-softest p-3 rounded-full text-danger" name="Trash" size={48} weight="thin" />
			</Flex>
			<p class="text-center w-[40ch] text-danger text-sm">This process will remove this location and all associated data from the database.</p>
			<p class="text-center w-[40ch]">Are you sure you want to delete this location?</p>
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
			/>
		</Flex>

	</Form>

{:else}

	<p class="font-style-placeholder">The form couldn't display correctly because no Character entity was provided.</p>

{/if}