<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

    let {
		isOpen,
		location,
		oncancel = () => {},
	} = $props()

	const form = useForm({
		name: location?.name || ''
	});
</script>





<ModalForm title="Rename {location?.name}?" size="sm"
	endpoint={route('locations.update', { location: location.slug})}
	form={form}
	method="patch"
	reloadPageProps={['locations', 'location']}
	submitProps={{
		label: 'Update'
	}}
>
	<Stack class="p-3 pt-0">
		<Field type="text"
			name="name"
			placeholder="New name"
			defaultValue={location?.name}
			required
			autofocus
		/>
	</Stack>
</ModalForm>