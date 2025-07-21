<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Panel from '@/Components/Panel'

	let project = $page.props.active_project.data
	let factions = project.factions

</script>

<Panel
	searchable
	items={[
		...factions.map(faction => {
			return {
				icon:   'FlagBannerFold',
				label:  faction.name,
				image:  faction.image_path,
				href:   route('factions.show', {faction: faction.slug}),
				active: $page.url == `/factions/${faction.slug}` || $page.url.startsWith(`/factions/${faction.slug}/`)
			}
		})
	]}
/>