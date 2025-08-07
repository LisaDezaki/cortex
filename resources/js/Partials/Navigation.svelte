<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Avatar from '@/Components/Avatar.svelte'
	import Nav from '@/Components/Nav'
	import ProjectSelect from '@/Components/ProjectSelect.svelte'
	import ThemeSwitch from '@/Components/ThemeSwitch.svelte'

	const user = $page.props.auth.user.data;
	const projects = $page.props.projects.data;
	const activeProject = $page.props.activeProject.data;

</script>

<Nav>

	{#snippet header()}
		<div class="flex flex-col items-center gap-2 px-2 pt-2 w-full">
			<div class="flex items-center justify-between w-full">
				<Nav.Logo />
				<Avatar class="w-10 hover:outline hover:outline-1 hover:outline-emerald-500 hover:-outline-offset-1" src={user.avatar.url} />
			</div>
			<ProjectSelect projects={projects} active={activeProject?.id} />
		</div>
	{/snippet}

	{#if activeProject}
		<div class="flex flex-col px-2">
			<Nav.Item icon="UsersThree"     label="Characters" href={route('characters')} 	active={$page.url.startsWith('/characters')} badge={activeProject?.characters?.length} />
			<Nav.Item icon="Chats"          label="Dialogue"   href="/dialogue"   			active={$page.url.startsWith('/dialogue')}   badge={activeProject?.dialogue?.length}  />
			<Nav.Item icon="CalendarDots"   label="Events"     href="/events"     			active={$page.url.startsWith('/events')}     badge={activeProject?.events?.length}  />
			<Nav.Item icon="FlagBannerFold" label="Factions"   href={route('factions')}   	active={$page.url.startsWith('/factions')}   badge={activeProject?.factions?.length} />
			<Nav.Item icon="Backpack"       label="Items"      href="/items"      			active={$page.url.startsWith('/items')}      badge={activeProject?.items?.length}  />
			<Nav.Item icon="MapPinArea"     label="Locations"  href={route('locations')}  	active={$page.url.startsWith('/locations')}  badge={activeProject?.locations?.length}  />
			<Nav.Item icon="Wrench"         label="Mechanics"  href="/mechanics"  			active={$page.url.startsWith('/mechanics')}  badge={activeProject?.mechanics?.length}  />
			<Nav.Item icon="Trophy"         label="Quests"     href="/quests"     			active={$page.url.startsWith('/quests')}     badge={activeProject?.quests?.length}  />
			<Nav.Item icon="Butterfly"      label="Wildlife"   href="/wildlife"   			active={$page.url.startsWith('/wildlife')}   badge={activeProject?.wildlife?.length}  />
			<Nav.Item icon="Books"          label="Glossary"   href="/glossary"   			active={$page.url.startsWith('/glossary')}   badge={activeProject?.glossary?.length}  />
		</div>
	{/if}

	{#snippet footer()}
		<div class="flex flex-col px-2">
			<ThemeSwitch />
			<Nav.Item icon="GearFine"   	 label="Settings"         href={route('settings')} 			active={$page.url.startsWith('user/settings')} />
			<Nav.Item icon="SignOut"    	 label="Log Out"          href={route('logout')} as="button" method="post" class="text-rose-400" />
		</div>
	{/snippet}
</Nav>