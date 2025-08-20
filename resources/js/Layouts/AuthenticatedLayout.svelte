<script>
	import { page } from '@inertiajs/svelte';
	import { Pane, Splitpanes } from 'svelte-splitpanes'

	import Navigation from '@/Partials/Navigation.svelte'
	import { Flex, Stack } from '@/Components/Core'
    import Article    from '@/Components/UI/Article.svelte'
    import Container  from '@/Components/UI/Container.svelte'
    import Main       from '@/Components/UI/Main.svelte'
    import Page       from '@/Components/UI/Page.svelte'
    import Sidebar    from '@/Components/UI/Sidebar.svelte'

	const activeProject = $page.props.activeProject.data;

    let {
		article,
		header,
		menu,
		sidebar
	} = $props()

</script>

<Page>

	<Navigation project={activeProject} />

	<Stack class="w-full">
		{@render header?.()}
		<Flex class="relative flex-grow-0 h-screen overflow-hidden w-full">
			<!-- <Splitpanes> -->
				<!-- <Pane> -->
					<Main>
						<!-- <Container class="flex items-start gap-6"> -->
							<!-- {@render menu?.()} -->
							<Article>
								{@render article?.()}
							</Article>
						<!-- </Container> -->
					</Main>
				<!-- </Pane> -->
				<!-- {#if sidebar}
					<Pane minSize={19.1} size={25} maxSize={50}>
						<Sidebar>
							{@render sidebar()}
						</Sidebar>
					</Pane>
				{/if} -->
			<!-- </Splitpanes> -->
		</Flex>
	</Stack>


</Page>