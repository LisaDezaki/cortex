<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import CustomFieldForm from '@/Forms/CustomFieldForm.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharacterTable from './Partials/CharacterTable.svelte'
	import Article from '@/Components/Article.svelte'
	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
    import Card from '../../Components/Card.svelte'
    import CardGrid from '../../Components/CardGrid.svelte'
	import Dialog from '@/Components/Dialog.svelte'
	import Form from '@/Components/Form'
	import Heading from '@/Components/Heading.svelte'
	import Icon from '@/Components/Icon.svelte'
	import Modal from '@/Components/Modal.svelte'
	import Sidebar from '@/Components/Sidebar.svelte'
	import Tag from '@/Components/Tag.svelte'

	let project = $page.props.active_project.data
	let characters = project?.characters

	let creatingCharacter = $state(false)
	let layoutType        = $state('grid')
	let selectionMode     = $state(false)
	let query             = $state('')
	let filteredCharacters = $state(characters)
	let selectedCharacters = $state([])

	function createCharacter() {
        creatingCharacter = true
    }
	function closeModal() {
		creatingCharacter = false
    }

	function filterCharacters(e) {
		filteredCharacters = query.length == 0
			? characters
			: characters.filter(c => {
				let string = `${c.name} ${c.alias}`;
				return string.toLowerCase().includes(e.target.value.toLowerCase());
			})
	}

</script>

<svelte:head>
    <title>{project.name} Characters</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet header()}
		<Breadcrumbs data={[ { title: "Project", href: "/" }, { title: "Characters" } ]} />
		<Button plain iconSize={24} iconWeight="light" icon="GearFine" href={route('characters.settings')} class="inline-flex items-center justify-center w-12 flex-shrink-0 aspect-square border-l hover:bg-slate-500/10" />
		<Button plain iconSize={24} iconWeight="light" icon="Plus"     href={route('characters.create')}   class="inline-flex items-center justify-center w-12 flex-shrink-0 aspect-square border-l hover:bg-emerald-500/10 text-emerald-500" />
	{/snippet}

	<Article class="w-full px-20 py-12 overflow-y-auto" bodyclass="space-y-6">

		<Heading is="h2" as="h4"
			heading="Character List"
			subheading="Manage your characters here."
		/>

		<div class="flex">
			<Form.Input icon="Search" name="search" placeholder="Search characters..." bind:value={query} oninput={filterCharacters} />
			<Button plain iconSize={24} iconWeight="light" icon="GridFour" onclick={() => layoutType = 'grid'}  class={layoutType == 'grid'  ? "text-emerald-500" : ""} />
			<Button plain iconSize={24} iconWeight="light" icon="Table"    onclick={() => layoutType = 'table'} class={layoutType == 'table' ? "text-emerald-500" : ""} />
		</div>

		{#if project && characters.length > 0}
			<div class="flex flex-col gap-6">
				{#if layoutType == 'table'}
					<CharacterTable characters={filteredCharacters} bind:selected={selectedCharacters} {selectionMode} />
				{:else}
					<CardGrid class="xl:grid-cols-6 lg:grid-cols-4 md:grid-cols-3" items={filteredCharacters}>
						{#snippet card(character)}
							<Card
								class="aspect-[3/4]"
								image={character.image_path}
								icon="User"
								title={character.name}
								subtitle={character.subtitle}
								href={route('characters.show', {character: character.slug})}
							/>
						{/snippet}
					</CardGrid>
				{/if}
			</div>
		{/if}
	</Article>

	<Sidebar class="space-y-6">
		<CustomFieldsPanel />
	</Sidebar>

</AuthenticatedLayout>