<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharactersPanel from '@/Partials/CharactersPanel.svelte'
	import CharacterForm from '@/Forms/Character/Character.svelte'
	import Back from '@/Components/UI/Back.svelte'

	const activeProject = $page.props.activeProject.data

</script>





<svelte:head>
    <title>{activeProject.name} / New Character</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet panel()}
		<CharactersPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('characters')} />
		<CharacterForm />
	{/snippet}

	{#snippet sidebar()}
		Empty
	{/snippet}

</AuthenticatedLayout>