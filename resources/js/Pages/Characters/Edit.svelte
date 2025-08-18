<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharactersPanel from '@/Partials/CharactersPanel.svelte'
	
	import CharacterForm       from '@/Forms/Character/Character.svelte'
	import DeleteCharacterForm from '@/Forms/Character/Delete.svelte'
	
	import Back       from '@/Components/UI/Back.svelte'
	import Container  from '@/Components/UI/Container.svelte'
	import Modal      from '@/Components/UI/Modal.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'

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
    <title>Edit {character.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
				{ label: "Characters",   href: route('characters') },
				{ label: character.name, href: route('characters.show', { character: character.slug }) },
			]}
			back={route('characters.show', { character: character.slug })}
			title="Edit Character"
			actions={[
				{ icon: "Trash", onclick: deleteCharacter, theme: "danger" }
			]}
		/>
	{/snippet}

	<!-- {#snippet panel()}
		<CharactersPanel />
	{/snippet} -->

	{#snippet article()}
		<Container size="7xl" class="flex gap-12">
			<CharacterForm {character} class="overflow-y-auto py-12" />
		</Container>
		<!-- <Back href={route('characters.show', {character: character.slug})} /> -->
	{/snippet}

	<!-- {#snippet sidebar()}
		Empty
	{/snippet} -->

</AuthenticatedLayout>

<Modal show={deletingCharacter} onclose={closeModal}>
	<DeleteCharacterForm {character} oncancel={closeModal} />
</Modal>