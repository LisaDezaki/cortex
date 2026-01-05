<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Grid, Stack, UploadContext } from '@/Components/Core'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

    let {
		type,
		...restProps
	} = $props()

	const form = useForm({
		name:  '',
		slug: ''
	})
</script>



<ModalForm
	size="lg"
	form={form}
	method="post"
	submitProps={{ label: 'Create' }}
{...restProps}>
	<Grid cols={3} gap={2} class="px-2 w-full">
		<Field
			class="col-span-2"
			type="text"
			name="name"
			placeholder="Name"
			required
		/>
		<Field
			class="col-span-1"
			type="text"
			name="slug"
			placeholder={$form.name?.toLowerCase()
				.replace(/[^\w\s\u00C0-\u017F]/g, '')	//	Remove punctuation
				.replace(/\s+/g, '-')					//	Replace spaces with hyphens
				.replace(/^-+|-+$/g, '') 				//	Remove leading/trailing hyphens
				.replace(/--+/g, '-')					//	Replace multiple hyphens with single hyphen
				.trim()									//	Remove leading/trailing spaces
			|| 'Slug'}
		/>
	</Grid>
</ModalForm>