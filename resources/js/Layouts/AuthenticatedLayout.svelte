<script>
	import { page } from '@inertiajs/svelte';
	import { Pane, Splitpanes } from 'svelte-splitpanes';

	import Navigation from '@/Partials/Navigation.svelte';
    import Article    from '@/Components/UI/Article.svelte';
    import Main       from '@/Components/UI/Main.svelte';
    import Page       from '@/Components/UI/Page.svelte';
    import Sidebar    from '@/Components/UI/Sidebar.svelte';

	const activeProject = $page.props.activeProject.data;

    let {
		article,
		panel,
		sidebar
	} = $props()

</script>

<Page>

	<Navigation project={activeProject} />

	<div class="relative flex flex-grow-0 flex-col h-screen overflow-hidden w-full">
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