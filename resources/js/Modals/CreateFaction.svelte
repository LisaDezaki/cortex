<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Stack, UploadContext } from '@/Components/Core'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

    let {
	} = $props()

	const form = useForm({
		name: '',
		type: '',
		media: null,
	});
</script>





<ModalForm title="Creating faction" size="md"
	endpoint={route('factions.store')}
	form={form}
	method="post"
	submitProps={{
		label: 'Create'
	}}
>
	<Flex align="center" gap={3} class="p-3 pt-0">
		<UploadContext
			name="media"
			type="emblem"
			class="relative flex items-center justify-center shrink-0 bg-white border-b border-neutral-softer h-24 w-24 rounded-lg"
		/>
		<Stack gap={3} class="w-full">
			<Field type="text"
				name="name"
				placeholder="Faction name"
				required
			/>
			<Field type="text"
				name="type"
				placeholder="Faction type"
			/>
		</Stack>
	</Flex>
</ModalForm>