<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Icon		 from '@/Components/UI/Icon.svelte'
	import ModalForm from '@/Components/UI/ModalForm.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

    let {
		faction,
	} = $props()

	const form = useForm({});
</script>





<ModalForm title="Delete {faction?.name}" size="md"
	endpoint={route('factions.destroy', { faction: faction.slug})}
	form={form}
	method="delete"
	reloadPageProps={['factions']}
	submitProps={{
		label: 'Yes, Delete',
		theme: 'danger'
	}}
>
	<Flex align="start" gap={6} class="mb-1.5 p-3 pt-0">
		{#if faction && faction.image}
			<Thumbnail class="aspect-square w-20" src={faction.image?.url} />
		{:else}
			<Icon class="aspect-square bg-danger-softest my-1 p-2 rounded-full text-danger" name="Trash" size={24} />
		{/if}
		<Stack gap={2}>
			<p>This process will remove this faction and all associated data from the database.</p>
			<p><strong>Are you sure you want to delete this faction?</strong></p>
		</Stack>
	</Flex>
</ModalForm>