<script>
	import { page } from '@inertiajs/svelte';
	import { Pane, Splitpanes } from 'svelte-splitpanes';

	import Navigation from '@/Partials/Navigation.svelte';
    import Article from '@/Components/Article.svelte';
    import Main from '@/Components/Main.svelte';
    import Page from '@/Components/Page.svelte';
    import Sidebar from '@/Components/Sidebar.svelte';
    import StickyHeader from '@/Components/StickyHeader.svelte';

    let {
		article,
		header,
		panel,
		sidebar
	} = $props()

	let project = $page.props.active_project.data;

</script>

<Page>

	<Navigation {project} />

	<div class="relative flex flex-grow-0 flex-col h-screen overflow-hidden w-full">
		{#if header}
			<StickyHeader>
				{@render header()}
			</StickyHeader>
		{/if}
		<Main>
			{@render panel?.()}
			<Splitpanes>
				<Pane>
					<Article>
						{@render article?.()}
					</Article>
				</Pane>
				{#if sidebar}
					<Pane minSize={19.1} size={25} maxSize={50}>
						<Sidebar>
							{@render sidebar()}
						</Sidebar>
					</Pane>
				{/if}
			</Splitpanes>
		</Main>
	</div>

</Page>