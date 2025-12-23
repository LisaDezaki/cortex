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
	} = $props()

	const form = useForm({
		customField: {
			id: field.id || null,
			value: entity.customFieldValues?.find(f => f.name === field.name)?.value || '',
		}
	})

</script>



<ModalForm title="Set {field.name} for {entity.name}" size="xl"
	endpoint={endpoint}
	form={form}
	method="patch"
	submitProps={{
		label: 'Save'
	}}
>
	<Box class="px-4 pb-4">
		<Input
			{...field}
			label={undefined}
			bind:value={$form.customField.value}
		/>
	</Box>
</ModalForm>