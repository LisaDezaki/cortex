<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import CharactersLayout from '@/Layouts/CharactersLayout.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';

	let project = $page.props.active_project.data

</script>

<svelte:head>
    <title>{project.name} / Faction Settings</title>
</svelte:head>

<CharactersLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",      href: "/" },
			{ title: "Characters",   href: route('characters') },
			{ title: "Settings" }
		]} />
	{/snippet}

	<section class="grid grid-cols-5 gap-12 px-12 py-6">
		Settings
	</section>

</CharactersLayout>