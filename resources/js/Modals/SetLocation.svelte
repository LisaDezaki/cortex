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
		title,
		...restProps
	} = $props()

	const form = useForm({
		[field]: entity[field]?.id || locations.getWorldMap().id,
		coordinates: [0,0]
	})

	function mapClick(item) {
		$form[field] = item.mappable?.id || item[field]?.id
	}

</script>



<ModalForm title={title || `Set location: ${entity.name}`} size="7xl"
	endpoint={endpoint}
	form={form}
	method="patch"
	submitProps={{ text: 'Confirm' }}
{...restProps}>
	<Map.Context
		class="flex-col w-full"
		location={locations.find($form[field])}
	>
		<Map.Preview
			class="aspect-[2/3] sm:aspect-square md:aspect-video max-h-[80vh] w-full"
			onBackClick={mapClick}
			onItemClick={mapClick}
		/>
	</Map.Context>
</ModalForm>