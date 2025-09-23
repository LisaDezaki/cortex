<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Stack } from '@/Components/Core'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

    let {
		character,
	} = $props()

	const form = useForm({
		name: character?.name || ''
	});
</script>





<ModalForm title="Rename {character?.name}?" size="lg"
	endpoint={route('characters.update', { character: character.slug})}
	form={form}
	method="patch"
	reloadPageProps={['characters', 'character']}
	submitProps={{
		label: 'Update'
	}}
>
	<Stack class="px-6 py-3">
		<Field type="text"
			name="name"
			placeholder="New name"
			defaultValue={character?.name}
			required
			autofocus
		/>
	</Stack>
</ModalForm>