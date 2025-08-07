<!-- <script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	import { Pane, Splitpanes } from 'svelte-splitpanes';
	
	import Navigation from '@/Partials/Navigation.svelte'
    import Main from '@/Components/Main.svelte'
    import Page from '@/Components/Page.svelte'
	import Panel from '@/Components/Panel'
	import StickyHeader from '@/Components/StickyHeader.svelte'

    let { children, header } = $props()

	let activeProject = $page.props.activeProject.data;

</script>

<Page class="flex items-stretch">

	<Navigation project={activeProject} />

	<Panel class="border-r pt-12">
		<Panel.Item icon="UserList"   label="Profile"       href={route('profile.edit')} active={$page.url.startsWith('/user/profile')} />
		<Panel.Item icon="GlobeStand" label="Projects"      href={route('projects')}     active={$page.url.startsWith('/user/projects')} />
		<Panel.Item icon="Textbox"    label="Custom Fields" href='/user/custom-fields'   active={$page.url.startsWith('/user/custom-fields')} />
		<Panel.Item icon="GearFine"   label="Settings"      href={route('settings')}     active={$page.url.startsWith('/user/settings')} />
		<Panel.Item icon="SignOut"    label="Log Out"       href={route('logout')}       as="button" method="post" class="text-rose-500" />
	</Panel>

    <div class="relative flex flex-col h-screen w-full">
		{#if header}
			<StickyHeader>
				{@render header()}
			</StickyHeader>
		{/if}
		{#if children}
			<Main>
				<Splitpanes>
					{@render children()}
				</Splitpanes>
			</Main>
		{/if}
	</div>
	
</Page> -->