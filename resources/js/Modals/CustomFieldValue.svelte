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
		title,
		...restProps
	} = $props()

	const form = useForm({
		customField: {
			id: field.id || null,
			value: entity.customFieldValues?.find(f => f.name === field.name)?.value || '',
		}
	})

</script>



<ModalForm title={title || `Set ${field.name}: ${entity.name}`} size="sm"
	form={form}
	method="patch"
	submitProps={{ label: 'Save' }}
{...restProps}>
	<Box class="px-2">
		<Input class="w-full"
			{...field}
			label={undefined}
			bind:value={$form.customField.value}
			autofocus
		/>
	</Box>
</ModalForm>