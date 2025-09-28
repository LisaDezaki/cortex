<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Stack } from '@/Components/Core'
	import Icon		 from '@/Components/UI/Icon.svelte'
	import ModalForm	 from '@/Components/UI/ModalForm.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

    let {
		character
	} = $props()

	const form = useForm({});
</script>





<ModalForm title="Deleting {character?.name}" size="md"
	endpoint={route('characters.destroy', { character: character.slug})}
	form={form}
	method="delete"
	reloadPageProps={['characters']}
	submitProps={{
		label: 'Yes, Delete',
		theme: 'danger'
	}}
>
	<Flex align="center" gap={6} class="p-3 pt-0">
		{#if character && character.image}
			<Thumbnail class="aspect-square w-24" src={character.image?.url} />
		{:else}
			<Icon class="aspect-square bg-danger-softest my-1 p-2 rounded-full text-danger" name="Trash" size={24} />
		{/if}
		<Stack gap={2}>
			<p>This process will remove this character and all associated data from the database.</p>
			<p><strong>Are you sure you want to delete this character?</strong></p>
		</Stack>
	</Flex>
</ModalForm>