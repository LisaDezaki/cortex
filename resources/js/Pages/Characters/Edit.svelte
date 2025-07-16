<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import CharactersLayout from '@/Layouts/CharactersLayout.svelte'
	import CharacterForm from './Partials/CharacterForm.svelte'
	import DeleteCharacterForm from './Partials/DeleteCharacterForm.svelte'
	import Article from '@/Components/Article.svelte';
	import Back from '@/Components/Back.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Modal from '@/Components/Modal.svelte'
	import Sidebar from '@/Components/Sidebar.svelte'

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

<CharactersLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",      href: "/" },
			{ title: "Characters",   href: route('characters') },
			{ title: character.name, href: route('characters.show', {character: character.slug}) },
			{ title: "Edit" }
		]} />
		<Button plain iconSize={24} iconWeight="light" icon="Trash" onclick={deleteCharacter} class="inline-flex items-center justify-center w-12 flex-shrink-0 aspect-square border-l hover:bg-rose-500/10 text-rose-500" />
	{/snippet}

	<Article class="w-full px-20 py-12 overflow-y-auto" bodyclass="space-y-6">
		<Back href={route('characters')} />
		<CharacterForm character={character} />
	</Article>

	<Sidebar>
	</Sidebar>

</CharactersLayout>

<Modal show={deletingCharacter} onclose={closeModal}>
	<DeleteCharacterForm {character} oncancel={closeModal} />
</Modal>