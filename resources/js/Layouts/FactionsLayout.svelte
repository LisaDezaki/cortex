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
	let factions = project?.factions;

</script>

<Page class="flex items-stretch">

	<Navigation {project} />

	<Panel
		searchable
		items={[
			...factions.map(faction => {
				return {
					icon:   'FlagBannerFold',
					label:  faction.name,
					image:  faction.image_path,
					href:   route('factions.show', {faction: faction.slug}),
					active: $page.url.startsWith(`/factions/${faction.slug}`)
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