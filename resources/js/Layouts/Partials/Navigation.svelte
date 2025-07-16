<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Avatar from '@/Components/Avatar.svelte'
	import Nav from '@/Components/Nav'
	import ProjectSelect from '@/Components/ProjectSelect.svelte'
	import ThemeSwitch from '@/Components/ThemeSwitch.svelte'

	let projects = $page.props.projects.data;
	let project = $page.props.active_project.data;

</script>

<Nav>

	{#snippet header()}
		<div class="flex flex-col items-center gap-2 px-2 pt-2 w-full">
			<div class="flex items-center justify-between w-full">
				<Nav.Logo />
				<Link href={route('profile.edit')}>
					<Avatar class="w-9 border-emerald-400" src="/img/avatar.jpg" alt="User" />
				</Link>
			</div>
			<ProjectSelect projects={projects} active={project?.id} />
		</div>
	{/snippet}

	{#if project}
		<div class="flex flex-col px-2">
			<Nav.Item icon="Speedometer"    label="Dashboard"  href="/dashboard"  active={$page.url === '/dashboard'} />
			<Nav.Item icon="UsersThree"     label="Characters" href="/characters" active={$page.url.startsWith('/characters')} badge={project?.characters?.length} />
			<Nav.Item icon="Chats"          label="Dialogue"   href="/dialogue"   active={$page.url.startsWith('/dialogue')}   badge={project?.dialogue?.length}  />
			<Nav.Item icon="CalendarDots"   label="Events"     href="/events"     active={$page.url.startsWith('/events')}     badge={project?.events?.length}  />
			<Nav.Item icon="FlagBannerFold" label="Factions"   href="/factions"   active={$page.url.startsWith('/factions')}   badge={project?.factions?.length} />
			<Nav.Item icon="Backpack"       label="Items"      href="/items"      active={$page.url.startsWith('/items')}      badge={project?.items?.length}  />
			<Nav.Item icon="MapPinArea"     label="Locations"  href="/locations"  active={$page.url.startsWith('/locations')}  badge={project?.locations?.length}  />
			<Nav.Item icon="Wrench"         label="Mechanics"  href="/mechanics"  active={$page.url.startsWith('/mechanics')}  badge={project?.mechanics?.length}  />
			<Nav.Item icon="Trophy"         label="Quests"     href="/quests"     active={$page.url.startsWith('/quests')}     badge={project?.quests?.length}  />
			<Nav.Item icon="Butterfly"      label="Wildlife"   href="/wildlife"   active={$page.url.startsWith('/wildlife')}   badge={project?.wildlife?.length}  />
			<Nav.Item icon="Books"          label="Glossary"   href="/glossary"   active={$page.url.startsWith('/glossary')}   badge={project?.glossary?.length}  />
		</div>                                                                                                    
	{/if}

	{#snippet footer()}
		<div class="flex flex-col px-2">
			<ThemeSwitch />
			<Nav.Item icon="Question"   label="Help and support" href="/help"      		active={$page.url.startsWith('user/help')}     />
			<!-- <Nav.Item icon="UserList"   label="Profile"          href="/user/profile" 	active={$page.url.startsWith('user/profile')}  /> -->
			<Nav.Item icon="GearFine"   label="Settings"         href="/user/settings" 	active={$page.url.startsWith('user/settings')} />
			<Nav.Item icon="SignOut"    label="Log Out"          href={route('logout')} as="button" method="post" class="text-rose-400" />
		</div>
	{/snippet}
</Nav>