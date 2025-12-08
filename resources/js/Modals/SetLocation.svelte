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
	} = $props()

	const form = useForm({
		location: entity.location?.id || locations.getWorldMap().id,
		coordinates: [0,0]
	})

	// function updateLocation(id) {
	// 	$form.location = id
	// }

	function mapClick(item) {
		$form.location = item.mappable?.id || item.location?.id
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
		location={locations.find($form.location)}
	>
		<Map.Preview
			class="aspect-square w-full"
			onBackClick={mapClick}
			onItemClick={mapClick}
		/>
	</Map.Context>
</ModalForm>