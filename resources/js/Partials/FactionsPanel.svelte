<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Panel from '@/Components/Panel.svelte'

	const activeProject = $page.props.activeProject.data
	const factions = activeProject.factions

</script>

<Panel
	searchable
	items={[
		...factions.map(faction => {
			return {
				icon:   'FlagBannerFold',
				label:  faction.name,
				image:  faction.emblem?.url,
				href:   route('factions.show', {faction: faction.slug}),
				active: $page.url == `/factions/${faction.slug}` || $page.url.startsWith(`/factions/${faction.slug}/`)
			}
		})
	]}
/>