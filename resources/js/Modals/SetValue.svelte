<script>
    import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Box, Flex, Stack, UploadContext } from '@/Components/Core'
	import Map from '@/Components/Core/Map'
	import Field  from '@/Components/UI/Field.svelte'
	import Input  from '@/Components/UI/Input'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

    let {
		endpoint,
		entity,
		field,
		label,
		title = 'Set Value',
	} = $props()

	const form = useForm({
		[field.name]: entity[field.name] || '',
	})

</script>



<ModalForm title={title} size="xl"
	endpoint={endpoint}
	form={form}
	method="patch"
	submitProps={{
		label: 'Save'
	}}
>
	<Box class="px-4 pb-4">
		<Field {...field} />
	</Box>
</ModalForm>