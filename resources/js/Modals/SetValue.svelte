<script>
    import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Box, Flex, Stack, UploadContext } from '@/Components/Core'
	import Map from '@/Components/Core/Map'
	import Field  from '@/Components/UI/Field.svelte'
	import Input  from '@/Components/UI/Input'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

    let {
		entity,
		field,
		label,
		title = 'Set Value',
		...restProps
	} = $props()

	const form = useForm({
		[field.name]: entity[field.name] || '',
	})

</script>



<ModalForm title={title} size={field.type === 'textarea' ? '2xl' : 'md'}
	form={form}
	method="patch"
	submitProps={{ label: 'Save' }}
{...restProps}>
	<Box class="px-2">
		<Field {...field} autofocus={true} />
	</Box>
</ModalForm>