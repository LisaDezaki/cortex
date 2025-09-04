<!-- <script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Panel from '@/Components/UI/Panel.svelte'

	const activeProject = $page.props.activeProject.data
	const characters = activeProject.characters

</script>

<Panel
	searchable
	items={[
		...characters.map(c => {
			return {
				icon:   'User',
				image:  c.portrait?.url,
				label:  c.name,
				href:   route('characters.show', {character: c.slug}),
				active: $page.url == `/characters/${c.slug}` || $page.url.startsWith(`/characters/${c.slug}/`)
			}
		})
	]}
/> -->