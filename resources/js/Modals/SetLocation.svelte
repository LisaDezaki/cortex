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
	} = $props()

	const form = useForm({
		parent_location: location.id,
		coordinates: [0,0]
	})

</script>



<ModalForm title="Set Location" size="5xl"
	endpoint={endpoint}
	form={form}
	method={method}
	submitProps={{
		label: 'Save'
	}}
>
	<Map class="aspect-video rounded-none w-full"
		location={location}
		setCoordinates
		bind:coordinates={$form.coordinates}
	/>
</ModalForm>