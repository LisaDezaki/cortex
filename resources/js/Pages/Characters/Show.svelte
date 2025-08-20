<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import DeleteCharacterForm from '@/Forms/Character/Delete.svelte'

	import CharacterTabs from './CharacterTabs.svelte'

	import { Grid, Stack, Tabs } from '@/Components/Core'

	import ArticleBanner     from '@/Components/UI/ArticleBanner.svelte'
	import Card       from '@/Components/UI/Card.svelte'
	import Container  from '@/Components/UI/Container.svelte'
	import Heading    from '@/Components/UI/Heading.svelte'
	import Modal      from '@/Components/UI/Modal.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'
	import Section    from '@/Components/UI/Section.svelte'
	import Thumbnail  from '@/Components/UI/Thumbnail.svelte'

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
    <title>{character.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
				{ label: "Characters",   href: route('characters') },
			]}
			back={route('characters')}
			title={character.name}
			actions={[
				{ icon: "Pen",   href: route('characters.edit', {character: character.slug}) },
				{ icon: "Trash", onclick: deleteCharacter, theme: "danger" }
			]}
		/>
	{/snippet}

	{#snippet article()}

		<CharacterTabs tab="details" class="overflow-y-auto">


			<!-- Details -->

			<Tabs.Content value="details" class="py-6">

				<ArticleBanner class="relative" image={character.banner?.url}>
					<Heading is="h1" as="h3" class="mt-auto z-10 {character.banner ? 'text-white' : ''}"
						heading={character.name}
						subheading={character.alias}
					/>
					<Thumbnail class="absolute right-12 -bottom-16 w-40" src={character.portrait?.url} />
				</ArticleBanner>

				<Heading is="h3" as="h5" heading="Description" class="mt-12 mb-6" />

				<p class="font-style-large max-w-[56ch] whitespace-pre-wrap">
					{character.description}
				</p>
		
			</Tabs.Content>


			<!-- Relationships -->

			<Tabs.Content value="relationships" class="py-12">
				<Heading is="h3" as="h5" class="mb-6"
					heading="Relationships"
				/>
				{#if character.relationships.length > 0}
					<Grid cols={6}>
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
				{/if}

			</Tabs.Content>


			<!-- Factions -->

			<Tabs.Content value="factions" class="py-12">
				<Heading is="h3" as="h5" class="mb-6"
					heading="Factions"
				/>
				{#if character.factions.length > 0}
					<Grid cols={6}>
						{#each character.factions as faction}
							<Card aspect="square"
								icon="FlagBannerFold"
								image={faction.emblem?.url}
								title={faction.name}
								subtitle={faction.role}
								href={route('factions.show', {faction: faction.slug})}
							/>
						{/each}
					</Grid>
				{/if}
			</Tabs.Content>


			<!-- Inventory -->

			<Tabs.Content value="items" class="py-12">
				<Heading is="h3" as="h5" class="mb-6"
					heading="Inventory"
				/>
				<!-- {#if character.inventory.length > 0}
					<Section id="factions" size="2xl">
						<Heading is="h4" as="h6" class="mb-6"
							heading="Inventory"
						/>
						<Grid cols={5}>
							{#each character.inventory as item}
								<Card aspect="square"
									icon="Backpack"
									image={item.emblem?.url}
									title={item.name}
									subtitle={item.role}
									href={route('items.show', {item: item.slug})}
								/>
							{/each}
						</Grid>
					</Section>
				{/if} -->
			</Tabs.Content>


			<!-- Media -->

			<Tabs.Content value="media" class="py-12">
				<Heading is="h3" as="h5" class="mb-6"
					heading="Media"
				/>
			</Tabs.Content>

			
			<!-- Custom Fields -->

			<Tabs.Content value="custom" class="py-12">
				<Heading is="h3" as="h5" class="mb-6"
					heading="Custom Fields"
				/>
			</Tabs.Content>

		</CharacterTabs>
	
	{/snippet}

	<!-- {#snippet sidebar()}

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

	{/snippet} -->
	
</AuthenticatedLayout>

<Modal title="Delete {character.name}?" show={deletingCharacter} onclose={closeModal}>
	<DeleteCharacterForm {character} oncancel={closeModal} />
</Modal>