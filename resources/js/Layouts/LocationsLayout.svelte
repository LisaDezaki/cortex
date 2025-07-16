<script>
	import { page } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'
	
	import Navigation from './Partials/Navigation.svelte'
    import Main from '@/Components/Main.svelte'
    import Page from '@/Components/Page.svelte'
    import Thumbnail from '@/Components/Thumbnail.svelte'
	import Panel from '@/Components/Panel'

    let { children, header } = $props()

	let project = $page.props.active_project.data;
	let locations = project?.locations;

</script>

<Page class="flex items-stretch">

	<Navigation {project} />

	<Panel
		searchable
		items={[
			...locations.map(location => {
				return {
					icon:   'MapPin',
					label:  location.name,
					image:  location.image_path,
					href:   route('locations.show', {location: location.slug}),
					active: $page.url.startsWith(`/locations/${location.slug}`)
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