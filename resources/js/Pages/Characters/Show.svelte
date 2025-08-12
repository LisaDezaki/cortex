<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharactersPanel     from '@/Partials/CharactersPanel.svelte'
	import DeleteCharacterForm from '@/Forms/Character/Delete.svelte'

	import { Flex, Grid, Stack } from '@/Components/Core'

	import Back     from '@/Components/UI/Back.svelte'
	import Card     from '@/Components/UI/Card.svelte'
	import Heading  from '@/Components/UI/Heading.svelte'
	import Icon     from '@/Components/UI/Icon.svelte'
	import Modal    from '@/Components/UI/Modal.svelte'
	import Section  from '@/Components/UI/Section.svelte'

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
				<Grid cols={5}>
					{#each character.relationships as relationship}
						<Card aspect="square"
							icon="User"
							image={relationship.portrait?.url}
							title={relationship.name}
							subtitle={relationship.role}
							href={route('characters.show', {character: relationship.slug})}
						/>
					{/each}
				</Grid>
			</Section>
		{/if}
	{/snippet}

	{#snippet sidebar()}

		<Flex align="center" justify="center" class="aspect-square bg-slate-900/10 rounded-lg  border-slate-900/15 overflow-hidden max-w-64 mx-auto w-[80%]">
			{#if character.portrait}
				<img src={character.portrait.url} alt={character.slug} class="min-h-full min-w-full object-cover" />
			{:else}
				<Icon name="User" size={64} weight="thin" />
			{/if}
		</Flex>

		<Stack gap={1.5} class="py-3">
			{#if character.factions.length > 0}
				<Flex gap={3}>
					<span class="font-bold w-20">Faction</span>
					<Link class="line-clamp-1 text-emerald-500 hover:underline" href={route('factions.show', {faction: character.factions[0]?.slug})}>{character.factions[0]?.name}</Link>
				</Flex>
			{/if}

			{#if character.location}
				<Flex gap={3}>
					<span class="font-bold w-20">Location</span>
					<Link class="line-clamp-1 text-emerald-500 hover:underline" href={route('locations.show', {location: character.location.slug})}>{character.location?.name}</Link>
				</Flex>
			{/if}

			{#if character.customFieldValues.length > 0}
				{#each character.customFieldValues as field}
					<Flex gap={3}>
						<span class="font-bold w-20">{field.field.label}</span>
						<span class="line-clamp-1">{field.value}</span>
					</Flex>
				{/each}
			{/if}
		</Stack>

	{/snippet}
	
</AuthenticatedLayout>

<Modal title="Delete {character.name}?" show={deletingCharacter} onclose={closeModal}>
	<DeleteCharacterForm {character} oncancel={closeModal} />
</Modal>