<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

    let {
		location,
		isOpen = false,
		oncancel = () => {},
	} = $props()

	const form = useForm({});
</script>





<ModalForm title="Delete {location?.name}?" size="md"
	endpoint={route('locations.destroy', { location: location.slug})}
	form={form}
	method="delete"
	reloadPageProps={['locations']}
	submitProps={{
		label: 'Yes, Delete',
		theme: 'danger'
	}}
>
	<Flex align="start" gap={6} class="mb-1.5 p-3 pt-0">
		{#if location && location.image}
			<Thumbnail class="aspect-square w-20" src={location.image?.url} />
		{:else}
			<Icon class="aspect-square bg-danger-softest my-1 p-2 rounded-full text-danger" name="Trash" size={24} />
		{/if}
		<Stack gap={2}>
			<p>This process will remove this location and all associated data from the database.</p>
			<p><strong>Are you sure you want to delete this location?</strong></p>
		</Stack>
	</Flex>
</ModalForm>