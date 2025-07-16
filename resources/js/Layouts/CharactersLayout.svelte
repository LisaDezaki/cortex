<script>
	import { page } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'
	
	import Navigation from './Partials/Navigation.svelte'
    import Main from '@/Components/Main.svelte'
    import StickyHeader from '@/Components/StickyHeader.svelte'
    import Page from '@/Components/Page.svelte'
    import Thumbnail from '@/Components/Thumbnail.svelte'
	import Panel from '@/Components/Panel'

    let { children, header } = $props()

	let project = $page.props.active_project.data;
	let characters = project?.characters;

</script>

<Page class="flex items-stretch">

	<Navigation {project} />

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

    <div class="relative flex flex-col h-screen w-full">
		{#if header}
			<StickyHeader>
				{@render header()}
			</StickyHeader>
		{/if}
		{#if children}
			<Main>
				{@render children()}
			</Main>
		{/if}
	</div>
</Page>