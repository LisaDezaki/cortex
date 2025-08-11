<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharactersPanel from '@/Partials/CharactersPanel.svelte'
	import DeleteCharacterForm from '@/Forms/DeleteCharacterForm.svelte'

	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import Card from '@/Components/Card.svelte'
	import CardGrid from '@/Components/CardGrid.svelte'
    import CharacterCard from '@/Components/CharacterCard.svelte'
	import HeaderButton from '@/Components/HeaderButton.svelte'
	import Heading from '@/Components/Heading.svelte'
	import Icon from '@/Components/Icon.svelte'
	import Modal from '@/Components/Modal.svelte'
	import Section from '@/Components/Section.svelte'

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

	<!-- {#snippet header()}
		<Breadcrumbs data={[
			{ title: "Characters", href: route('characters') },
			{ title: character.name }
		]} />
		<HeaderButton icon="Pen"   theme="neutral" href={route('characters.edit', {character: character.slug})} />
		<HeaderButton icon="Trash" theme="danger"  onclick={deleteCharacter} />
	{/snippet} -->

	{#snippet panel()}
		<CharactersPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('characters')} />
		<Section>

			<Heading is="h1" as="h3" class="my-12"
				eyebrowIcon="User" eyebrow="Character"
				heading={character.name}
				subheading={character.alias}
				actions={[
					{ label: "Edit",   icon: "Pen",   href: route('characters.edit', {character: character.slug}) },
					{ label: "Delete", icon: "Trash", onclick: deleteCharacter, theme: "danger" }
				]}
			/>

			<p class="max-w-[65ch]">{character.description}</p>

			<!-- <div>
				<h6 class="font-style-regular font-bold">Appearance</h6>
				<p>{character.appearance}</p>
			</div>
			<div>
				<h6 class="font-style-regular font-bold">Personality</h6>
				<p>{character.personality}</p>
			</div>
			<div>
				<h6 class="font-style-regular font-bold">Motivations</h6>
				<p>{character.motivations}</p>
			</div>
			<div>
				<h6 class="font-style-regular font-bold">Flaws</h6>
				<p>{character.flaws}</p>
			</div> -->
		</Section>

		{#if character.relationships.length > 0}
			<Section>
				<Heading is="h2" as="h5" class="mb-6"
					heading="Relationships"
				/>
				<CardGrid cols={5}>
					{#each character.relationships as relationship}
						<Card aspect="square"
							icon="User"
							image={relationship.portrait?.url}
							title={relationship.name}
							subtitle={relationship.role}
							href={route('characters.show', {character: relationship.slug})}
						/>
					{/each}
				</CardGrid>
			</Section>
		{/if}
	{/snippet}

	{#snippet sidebar()}

		<div class="mx-auto flex items-center justify-center aspect-square bg-slate-900/10 rounded-lg  border-slate-900/15 overflow-hidden max-w-64 w-[80%]">
			{#if character.portrait}
				<img src={character.portrait.url} alt={character.slug} class="min-h-full min-w-full object-cover" />
			{:else}
				<Icon name="User" size={64} weight="thin" />
			{/if}
		</div>

		<div class="space-y-1.5 py-3">
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
		</div>

	{/snippet}
	
</AuthenticatedLayout>

<Modal show={deletingCharacter} onclose={closeModal}>
	<DeleteCharacterForm {character} oncancel={closeModal} />
</Modal>