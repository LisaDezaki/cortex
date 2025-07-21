<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Panel from '@/Components/Panel'

	let project = $page.props.active_project.data
	let locations = project.locations

</script>

<Panel
	searchable
	items={[
		...locations.map(location => {
			return {
				icon:   'MapPin',
				label:  location.name,
				image:  location.image_path,
				href:   route('locations.show', {location: location.slug}),
				active: $page.url == `/locations/${location.slug}` || $page.url.startsWith(`/locations/${location.slug}/`)
			}
		})
	]}
/>