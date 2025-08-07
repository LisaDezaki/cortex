<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Panel from '@/Components/Panel.svelte'

	const activeProject = $page.props.activeProject.data
	const characters = activeProject.characters

</script>

<Panel
	searchable
	items={[
		...characters.map(character => {
			return {
				icon:   'User',
				label:  character.name,
				image:  character.portrait?.url,
				href:   route('characters.show', {character: character.slug}),
				active: $page.url == `/characters/${character.slug}` || $page.url.startsWith(`/characters/${character.slug}/`)
			}
		})
	]}
/>