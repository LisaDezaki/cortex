<script>
	import { page } from '@inertiajs/svelte';

	import Navigation from './Partials/Navigation.svelte';
    import Main from '@/Components/Main.svelte';
    import Page from '@/Components/Page.svelte';
    import StickyHeader from '@/Components/StickyHeader.svelte';

    let { children, header } = $props()

	let project = $page.props.active_project.data;

</script>

<Page class="flex items-stretch">

	<Navigation {project} />

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