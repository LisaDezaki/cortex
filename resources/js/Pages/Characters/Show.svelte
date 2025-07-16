<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import CharactersLayout from '@/Layouts/CharactersLayout.svelte'
	import DeleteCharacterForm from './Partials/DeleteCharacterForm.svelte'
	import Article from '@/Components/Article.svelte'
	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import Card from '@/Components/Card.svelte'
	import Heading from '@/Components/Heading.svelte'
	import Icon from '@/Components/Icon.svelte'
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
			{ title: "Project",    href: "/" },
			{ title: "Characters", href: route('characters') },
			{ title: character.name }
		]} />
		<Button plain iconSize={24} iconWeight="light" icon="Pen"   href={route('characters.edit',   {character: character.slug})} class="inline-flex items-center justify-center w-12 flex-shrink-0 aspect-square border-l hover:bg-slate-500/10" />
		<Button plain iconSize={24} iconWeight="light" icon="Trash" onclick={deleteCharacter} class="inline-flex items-center justify-center w-12 flex-shrink-0 aspect-square border-l hover:bg-rose-500/10 text-rose-500" />
	{/snippet}

	<Article class="w-full px-20 py-12 overflow-y-auto" bodyclass="space-y-6">

		<Back href={route('characters')} />

		<section class="flex flex-col space-y-6 max-w-[40rem] mx-auto">

			<Heading is="h1" as="h3"
				heading={character.name}
				subheading={character.subtitle}
			/>

			<div>
				<h6 class="font-bold">Description</h6>
				<p>
					{character.description}
				</p>
			</div>
			<div>
				<h6 class="font-style-regular font-bold">Appearance</h6>
				<p class="font-style-regular">
					{character.appearance}
				</p>
			</div>
			<div>
				<h6 class="font-style-regular font-bold">Personality</h6>
				<p class="font-style-regular">
					{character.personality}
				</p>
			</div>
			<div>
				<h6 class="font-style-regular font-bold">Motivations</h6>
				<p class="font-style-regular">
					{character.motivations}
				</p>
			</div>
			<div>
				<h6 class="font-style-regular font-bold">Flaws</h6>
				<p class="font-style-regular">
					{character.flaws}
				</p>
			</div>
		</section>

		<section>
			{#if character.relationships.length > 0}
				<div class="px-6">
					<h4 class="font-style-h6 mb-2">Relationships</h4>
					<div class="grid grid-cols-6 gap-2">
						{#each character.relationships as relationship}
							<Card
								class="aspect-[3/4]"
								title={relationship.name}
								subtitle={relationship.role}
								image={relationship.image_path}
								href={route('characters.show', {character: relationship.slug})}
							/>
						{/each}
					</div>
				</div>
			{/if}
		</section>

	</Article>

	<Sidebar>

		<div class="mx-auto flex items-center justify-center aspect-square bg-slate-900/10 rounded-lg  border-slate-900/15 overflow-hidden max-w-64 w-[80%]">
			{#if character.image_path}
				<img src={character.image_path} alt={character.slug} class="min-h-full min-w-full object-cover" />
			{:else}
				<Icon name="User" size={64} weight="thin" />
			{/if}
		</div>

		<div class="space-y-1.5 px-6 py-3">
			{#if character.factions.length > 0}
				<div class="grid grid-cols-2 gap-3">
					<span class="col-span-1 font-bold text-right">Faction</span>
					<Link class="col-span-1 text-emerald-500 hover:underline" href={route('factions.show', {faction: character.factions[0]?.slug})}>{character.factions[0]?.name}</Link>
				</div>
			{/if}

			{#if character.location}
				<div class="grid grid-cols-2 gap-3">
					<span class="col-span-1 font-bold text-right">Location</span>
					<Link class="col-span-1 text-emerald-500 hover:underline" href={route('locations.show', {location: character.location.slug})}>{character.location?.name}</Link>
				</div>
			{/if}

			{#if character.custom_field_values.length > 0}
				{#each character.custom_field_values as field}
					<div class="grid grid-cols-2 gap-3">
						<span class="col-span-1 font-bold text-right">{field.custom_field_label}</span>
						<span class="col-span-1">{field.value}</span>
					</div>
				{/each}
			{/if}
		</div>

	</Sidebar>

	<Modal show={deletingCharacter} onclose={closeModal}>
		<DeleteCharacterForm {character} oncancel={closeModal} />
	</Modal>

</CharactersLayout>