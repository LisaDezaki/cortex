<script>
    import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Stack, UploadContext } from '@/Components/Core'
	import Map from '@/Components/Core/Map'
	import Field  from '@/Components/UI/Field.svelte'
	import ModalForm  from '@/Components/UI/ModalForm.svelte'

	import LocationList from '@/services/LocationList';

	const locations = new LocationList($page.props.activeProject?.data.locations)

    let {
		entity,
		endpoint,
		field = 'location',
	} = $props()

	const form = useForm({
		[field]: entity[field]?.id || locations.getWorldMap().id,
		coordinates: [0,0]
	})

	function mapClick(item) {
		$form[field] = item.mappable?.id || item[field]?.id
	}

</script>



<ModalForm title="Set the location for {entity.name}" size="xl"
	endpoint={endpoint}
	form={form}
	method="patch"
	submitProps={{
		label: 'Save'
	}}
>
	<Map.Context
		class="flex-col w-full"
		location={locations.find($form[field])}
	>
		<Map.Preview
			class="aspect-square w-full"
			onBackClick={mapClick}
			onItemClick={mapClick}
		/>
	</Map.Context>
</ModalForm>