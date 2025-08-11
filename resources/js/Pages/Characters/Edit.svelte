<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharactersPanel from '@/Partials/CharactersPanel.svelte'
	import CharacterForm from '@/Forms/CharacterForm.svelte'
	import DeleteCharacterForm from '@/Forms/DeleteCharacterForm.svelte'
	
	import Back from '@/Components/Back.svelte'
	import Modal from '@/Components/Modal.svelte'

	const activeProject = $page.props.activeProject.data
	const character = $page.props.character.data

	let deletingCharacter = $state(false)

	function deleteCharacter() {
        deletingCharacter = true
    }
	function closeModal() {
		deletingCharacter = false
    }

</script>





<svelte:head>
    <title>{activeProject.name} / {character.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet panel()}
		<CharactersPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('characters.show', {character: character.slug})} />
		<CharacterForm {character} />
	{/snippet}

	{#snippet sidebar()}
		Empty
	{/snippet}

</AuthenticatedLayout>

<Modal show={deletingCharacter} onclose={closeModal}>
	<DeleteCharacterForm {character} oncancel={closeModal} />
</Modal>