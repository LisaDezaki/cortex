<script>
    import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Grid, Stack, UploadContext } from '@/Components/Core'
	import Entity  		from '@/Components/UI/Entity.svelte'
	import Field  		from '@/Components/UI/Field.svelte'
	import ModalForm	from '@/Components/UI/ModalForm.svelte'
	import Thumbnail	from '@/Components/UI/Thumbnail.svelte'

	import LocationList from '@/services/LocationList'
	let locations = new LocationList($page.props.activeProject?.data.locations)

    let {
		endpoint,
		method,
		title
	} = $props()

	const form = useForm({
		location: null
	})

</script>



<ModalForm title={title || "Select Location"} size="sm"
	endpoint={endpoint}
	form={form}
	method={method}
	submitProps={{
		label: 'Select'
	}}
>
	<Stack gap={1.5} class="px-3">
		{#each locations.items as location}
			<Entity
				entity={location}
				subtitle={location.mapData?.location.name}
			/>
			<!-- <Flex align="center" gap={3} class="cursor-pointer px-2 py-1 rounded hover:bg-neutral-softest hover:text-accent">
				<Thumbnail src={location.image?.url} class="h-10 w-16 rounded-sm" />
				<Stack gap={0}>
					<span class="font-style-regular font-semibold line-clamp-1 w-full">{location.name}</span>
					<span class="font-style-small line-clamp-1 w-full">{location.parent?.name}</span>
				</Stack>
			</Flex> -->
		{/each}
	</Stack>
</ModalForm>