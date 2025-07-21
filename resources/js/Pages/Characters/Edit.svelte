<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharactersPanel from '@/Partials/CharactersPanel.svelte'
	import CharacterForm from '@/Forms/CharacterForm.svelte'
	import DeleteCharacterForm from '@/Forms/DeleteCharacterForm.svelte'
	
	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import Modal from '@/Components/Modal.svelte'

	let project = $page.props.active_project.data
	let character = $page.props.character.data

	let deletingCharacter = $state(false)

	function deleteCharacter() {
        deletingCharacter = true
    }
	function closeModal() {
		deletingCharacter = false
    }

</script>

<svelte:head>
    <title>{project.name} / {character.name}</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",      href: "/" },
			{ title: "Characters",   href: route('characters') },
			{ title: character.name, href: route('characters.show', {character: character.slug}) },
			{ title: "Edit" }
		]} />
		<Button style="plain" theme="danger" class="border-l"
			icon="Trash" iconSize={24} iconWeight="light"
			onclick={deleteCharacter}
		/>
	{/snippet}

	{#snippet panel()}
		<CharactersPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('characters.show', {character: character.slug})} />
		<CharacterForm {character} />
	{/snippet}

</AuthenticatedLayout>

<Modal show={deletingCharacter} onclose={closeModal}>
	<DeleteCharacterForm {character} oncancel={closeModal} />
</Modal>