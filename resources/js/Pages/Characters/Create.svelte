<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharactersPanel from '@/Partials/CharactersPanel.svelte'
	import CharacterForm from '@/Forms/CharacterForm.svelte'

	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'

	const activeProject = $page.props.activeProject.data

</script>

<svelte:head>
    <title>{activeProject.name} / New Character</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Characters", href: route('characters') },
			{ title: "Create" }
		]} />
	{/snippet}

	{#snippet panel()}
		<CharactersPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('characters')} />
		<CharacterForm />
	{/snippet}

	{#snippet sidebar()}
		asd
	{/snippet}

</AuthenticatedLayout>