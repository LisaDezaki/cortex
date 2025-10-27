<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Stack, UploadContext } from '@/Components/Core'
	import Field  from '@/Components/UI/Field.svelte'
	import Map  from '@/Components/Features/Location/Map.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

    let {
		endpoint,
		location,
		method,
		options = [],
		tags = $bindable([]),
		title = "Set Tags"
	} = $props()

	const form = useForm({
		tags: tags
	})

</script>



<ModalForm
	endpoint={endpoint}
	form={form}
	method={method}
	size="2xl"
	submitProps={{
		label: 'Save'
	}}
	title={title}
>
	<Stack gap={3} class="px-6 py-3">
		Active tags
		<Flex>
			{#each tags as tag}
				<Tag>{tag}</Tag>
			{/each}
		</Flex>
		All tags
		<Flex>
			{#each options as option}
				<Tag>{option}</Tag>
			{/each}
		</Flex>
	</Stack>
</ModalForm>