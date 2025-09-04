<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Panel from '@/Components/UI/Panel.svelte'

	const activeProject = $page.props.activeProject.data
	const locations = activeProject.locations

</script>

<Panel
	searchable
	items={[
		...locations.map(location => {
			return {
				icon:   'MapPinArea',
				label:  location.name,
				image:  location.banner?.url,
				href:   route('locations.show', {location: location.slug}),
				active: $page.url == `/locations/${location.slug}` || $page.url.startsWith(`/locations/${location.slug}/`)
			}
		})
	]}
/>