<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'
	import Modal  from '@/Components/UI/Modal.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

    let {
		faction,
		isOpen = false,
		oncancel = () => {},
	} = $props()

	const form = useForm({});
</script>





<Modal title="Delete {faction?.name}?"
	show={isOpen} maxWidth="lg" onclose={oncancel}>
	{#if faction && faction.slug}

		<Form
			class="max-w-lg"
			enctype="multipart/form-data"
			endpoint={route('factions.destroy', { faction: faction.slug})}
			form={form}
			method="delete"
			reloadPageProps={['factions']}
			processing={$form.processing}
			recentlySuccessful={$form.recentlySuccessful}
		>
			<Flex align="start" gap={6} class="mb-1.5 px-6 py-3">
				{#if faction && faction.image}
					<Thumbnail class="aspect-square w-20" src={faction.image?.url} />
				{:else}
					<Icon class="aspect-square bg-danger-softest my-1 p-2 rounded-full text-danger" name="Trash" size={24} />
				{/if}
				<Stack>
					<p>This process will remove this faction and all associated data from the database. <strong>Are you sure you want to delete this faction?</strong></p>
				</Stack>
			</Flex>

			<Flex gap={0} class="border-t flex-0 min-h-12">
				<Button style="hard" theme="neutral" class="border-none rounded-none w-1/2"
					type="button"
					label="Cancel"
					onclick={oncancel}
				/>
				<Button style="hard" theme="danger" class="border-none rounded-none w-1/2"
					type="submit"
					label="Yes, Delete this faction"
				/>
			</Flex>

		</Form>
	{:else}

		<p class="font-style-placeholder">The form couldn't display correctly because no Faction entity was provided.</p>

	{/if}
</Modal>