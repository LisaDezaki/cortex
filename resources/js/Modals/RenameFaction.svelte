<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Stack }   from '@/Components/Core'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

    let {
		faction,
	} = $props()

	const form = useForm({
		name: faction?.name || ''
	});
</script>





<ModalForm title="Rename {faction?.name}?" size="sm"
	endpoint={route('factions.update', { faction: faction.slug})}
	form={form}
	method="patch"
	reloadPageProps={['factions', 'faction']}
	submitProps={{
		label: 'Update'
	}}
>
	<Stack class="p-3 pt-0">
		<Field type="text"
			name="name"
			placeholder="New name"
			defaultValue={faction?.name}
			required
			autofocus
		/>
	</Stack>
</ModalForm>