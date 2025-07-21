<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Panel from '@/Components/Panel'

	let project = $page.props.active_project.data
	let characters = project.characters

</script>

<Panel
	searchable
	items={[
		...characters.map(character => {
			return {
				icon:   'User',
				label:  character.name,
				image:  character.image_path,
				href:   route('characters.show', {character: character.slug}),
				active: $page.url == `/characters/${character.slug}` || $page.url.startsWith(`/characters/${character.slug}/`)
			}
		})
	]}
/>