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
	import HeaderButton from '@/Components/HeaderButton.svelte'
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
	
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Characters",   href: route('characters') },
			{ title: character.name, href: route('characters.show', {character: character.slug}) },
			{ title: "Edit" }
		]} />
		<HeaderButton theme="danger" icon="Trash" onclick={deleteCharacter} />
	{/snippet}

	{#snippet panel()}
		<CharactersPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('characters.show', {character: character.slug})} />
		<CharacterForm {character} />
	{/snippet}

	{#snippet sidebar()}

		<!-- <div class="mx-auto flex items-center justify-center aspect-square bg-slate-900/10 rounded-lg  border-slate-900/15 overflow-hidden max-w-64 w-[80%]">
			{#if character.portrait}
				<img src={character.portrait.url} alt={character.slug} class="min-h-full min-w-full object-cover" />
			{:else}
				<Icon name="User" size={64} weight="thin" />
			{/if}
		</div> -->

		<!-- <div class="space-y-1.5 py-3">
			{#if character.factions.length > 0}
				<div class="grid grid-cols-3 gap-3">
					<span class="col-span-1 font-bold">Faction</span>
					<Link class="col-span-2 line-clamp-1 text-emerald-500 hover:underline" href={route('factions.show', {faction: character.factions[0]?.slug})}>{character.factions[0]?.name}</Link>
				</div>
			{/if}

			{#if character.location}
				<div class="grid grid-cols-3 gap-3">
					<span class="col-span-1 font-bold">Location</span>
					<Link class="col-span-2 line-clamp-1 text-emerald-500 hover:underline" href={route('locations.show', {location: character.location.slug})}>{character.location?.name}</Link>
				</div>
			{/if}

			{#if character.customFieldValues.length > 0}
				{#each character.customFieldValues as field}
					<div class="grid grid-cols-3 gap-3">
						<span class="col-span-1 font-bold">{field.field.label}</span>
						<span class="col-span-2">{field.value}</span>
					</div>
				{/each}
			{/if}
		</div> -->

	{/snippet}

</AuthenticatedLayout>

<Modal show={deletingCharacter} onclose={closeModal}>
	<DeleteCharacterForm {character} oncancel={closeModal} />
</Modal>