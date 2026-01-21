<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import { Flex, Stack } from '@/Components/Core'

	import Avatar      from '@/Components/UI/Avatar.svelte'
	import Nav         from '@/Components/UI/Nav'
	import Navatar     from '@/Components/UI/Navatar.svelte'
	import ThemeSwitch from '@/Components/UI/ThemeSwitch.svelte'

	import ProjectSelect from '@/Components/Custom/ProjectSelect.svelte'

	const user = $page.props.auth.user.data;
	const projects = $page.props.projects.data;
	const activeProject = $page.props.activeProject.data;

	let {
		active
	} = $props()

</script>

<Nav>

	{#snippet header()}
		<Stack align="center" gap={2} class="p-2 w-full">
			<Flex align="center" justify="between" class="w-full">
				<Nav.Logo class="hidden md:block" />
				<Navatar src={user.image?.url} fallback={user.name?.toUpperCase().substr(0,2)} href={route('user.edit')} />
			</Flex>
		</Stack>
		<Flex class="px-0 md:px-2">
			<ProjectSelect projects={projects} active={active} />
		</Flex>
	{/snippet}

	{#if activeProject}
		<Stack class="px-1 md:px-2">
			<Nav.Item icon="UsersThree"     label="Characters" href={route('characters')} 	active={$page.url.startsWith('/characters')} badge={activeProject?.characters?.length} />
			<!-- <Nav.Item icon="Chats"          label="Dialogue"   href="/dialogue"   			active={$page.url.startsWith('/dialogue')}   badge={activeProject?.dialogue?.length}  /> -->
			<!-- <Nav.Item icon="Sparkle"        label="Effects"    href="/effects"   			active={$page.url.startsWith('/effects')}   badge={activeProject?.effects?.length}  /> -->
			<!-- <Nav.Item icon="CalendarDots"   label="Events"     href="/events"     			active={$page.url.startsWith('/events')}     badge={activeProject?.events?.length}  /> -->
			<Nav.Item icon="FlagBannerFold" label="Factions"   href={route('factions')}   	active={$page.url.startsWith('/factions')}   badge={activeProject?.factions?.length} />
			<Nav.Item icon="Backpack"       label="Items"      href={route('items')}		active={$page.url.startsWith('/items')}      badge={activeProject?.items?.length}  />
			<Nav.Item icon="MapPinArea"     label="Locations"  href={route('locations')}  	active={$page.url.startsWith('/locations')}  badge={activeProject?.locations?.length}  />
			<!-- <Nav.Item icon="Wrench"         label="Mechanics"  href="/mechanics"  			active={$page.url.startsWith('/mechanics')}  badge={activeProject?.mechanics?.length}  /> -->
			<!-- <Nav.Item icon="Trophy"         label="Quests"     href="/quests"     			active={$page.url.startsWith('/quests')}     badge={activeProject?.quests?.length}  /> -->
			<!-- <Nav.Item icon="Butterfly"      label="Wildlife"   href="/wildlife"   			active={$page.url.startsWith('/wildlife')}   badge={activeProject?.wildlife?.length}  /> -->
			<Nav.Item icon="Books"          label="Codex"		href="/codex"   			active={$page.url.startsWith('/codex')}   badge={activeProject?.codex?.length}  />
		</Stack>
	{/if}

	{#snippet footer()}
		<Stack class="px-1 md:px-2">
			<ThemeSwitch />
			<Nav.Item icon="GearFine"	label="Settings"	href={route('user.settings')} active={$page.url.startsWith('user/settings')} />
			<Nav.Item icon="SignOut" 	label="Log Out" 	href={route('logout')} as="button" method="post" class="text-rose-400" />
		</Stack>
	{/snippet}
</Nav>