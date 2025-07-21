<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
	import CharacterTable from '@/Partials/CharacterTable.svelte'

	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
    import Card from '@/Components/Card.svelte'
    import CardGrid from '@/Components/CardGrid.svelte'
	import Form from '@/Components/Form'
	import Heading from '@/Components/Heading.svelte'
	import Section from '@/Components/Section.svelte'

	let project = $page.props.active_project.data
	let characters = project?.characters
	let custom_fields = $page.props.custom_fields

	let layoutType         = $state('table')
	let selectionMode      = $state(false)
	let query              = $state('')
	let filteredCharacters = $state(characters)
	let selectedCharacters = $state([])

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
		<Breadcrumbs data={[
			// { title: project.name, href: "/" },
			{ title: "Characters" }
		]} />
		<Button style="plain" theme="neutral" class="border-l"
			icon="GearFine" iconSize={24} iconWeight="light"
			href={route('characters.settings')}
		/>
		<Button style="plain" theme="accent" class="border-l"
			icon="Plus" iconSize={24} iconWeight="light"
			href={route('characters.create')}
		/>
	{/snippet}

	{#snippet article()}
		<Back href="/" />
		<Section class="space-y-6">
			<Heading is="h2" as="h4"
				heading="{project.name} Characters"
				subheading="Manage your characters here."
			/>
			<div class="flex items-center">
				<Form.Input bind:value={query}
					icon="Search" name="search" placeholder="Search characters..."
					oninput={filterCharacters}
				/>
				<Button class={layoutType === 'grid'  ? "text-emerald-500" : ""}
					icon="GridFour" iconSize={24} iconWeight="light"
					onclick={() => layoutType = 'grid'}
				/>
				<Button class={layoutType === 'table' ? "text-emerald-500" : ""}
					icon="Table" iconSize={24} iconWeight="light"
					onclick={() => layoutType = 'table'}
				/>
			</div>
			{#if project && characters.length > 0}
				{#if layoutType === 'table'}
					<CharacterTable characters={filteredCharacters} bind:selected={selectedCharacters} {selectionMode} />
				{:else if layoutType === 'grid'}
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
			{/if}
		</Section>
	{/snippet}

	{#snippet sidebar()}
		<CustomFieldsPanel />
	{/snippet}

</AuthenticatedLayout>