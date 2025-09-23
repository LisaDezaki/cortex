<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import { modalActions } from '@/stores/modalStore';
	
	import { Flex, Form, Stack, UploadContext, UploadPreview, UploadTrigger } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

	const locationTypes = $page.props.locationTypes

	let {
	} = $props()

	const form = useForm({
		name:  '',
		type:  '',
		media: null
	});
</script>





<ModalForm title="Create a new location" size="lg"
	endpoint={route('locations.store')}
	form={form}
	method="post"
	reloadPageProps={['locations']}
	submitProps={{
		label: 'Create'
	}}
>
	<Flex align="center" gap={3} class="px-6 py-3">
		<UploadContext
			name="media"
			type="banner"
			class="relative flex items-center justify-center shrink-0 bg-white border-b border-neutral-softer h-24 w-24 rounded-lg"
		/>
		<Stack gap={3} class="w-full">
			<Field type="text"
				name="name"
				placeholder="Location name"
				required
			/>
			<Field type="text"
				name="type"
				placeholder="Location type"
				suggestions={locationTypes}
			/>
		</Stack>
	</Flex>
</ModalForm>