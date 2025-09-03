<script>
	import { page } from '@inertiajs/svelte';
	import { Pane, Splitpanes } from 'svelte-splitpanes'

	import Navigation from '@/Partials/Navigation.svelte'
	import { Flex, Stack } from '@/Components/Core'
    import Article    from '@/Components/UI/Article.svelte'
    import Container  from '@/Components/UI/Container.svelte'
	import Toast				from '@/Components/UI/Toast.svelte'
    import Main       from '@/Components/UI/Main.svelte'
    import Page       from '@/Components/UI/Page.svelte'
    import Sidebar    from '@/Components/UI/Sidebar.svelte'

	const activeProject = $page.props.activeProject.data;

    let {
		article,
		header,
	} = $props()

</script>

<Page>

	<Navigation project={activeProject} />

	<Stack class="w-full">
		{@render header?.()}
		<Flex class="relative flex-grow-0 h-screen overflow-hidden w-full">
			<Main>
				<Article>
					{#if $page.props.flash}
						<Toast {...$page.props.flash} />
					{/if}
					{@render article?.()}
				</Article>
			</Main>
		</Flex>
	</Stack>


</Page>