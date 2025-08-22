<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import CustomFieldsForm  from '@/Forms/Character/Partials/CustomFieldsForm.svelte'
	import FactionsForm      from '@/Forms/Character/Partials/FactionsForm.svelte'
	import InventoryForm     from '@/Forms/Character/Partials/InventoryForm.svelte'
	import LocationForm      from '@/Forms/Character/Partials/LocationForm.svelte'
	import MediaForm         from '@/Forms/Character/Partials/MediaForm.svelte'
	import RelationshipsForm from '@/Forms/Character/Partials/RelationshipsForm.svelte'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import DeleteCharacterForm from '@/Forms/Character/Delete.svelte'

	import { Flex, Grid, Stack, Tabs } from '@/Components/Core'

	import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
	import ArticleTabs   from '@/Components/UI/ArticleTabs.svelte'
	import Card       	 from '@/Components/UI/Card.svelte'
	import Container  	 from '@/Components/UI/Container.svelte'
	import Heading    	 from '@/Components/UI/Heading.svelte'
	import Modal      	 from '@/Components/UI/Modal.svelte'
	import PageHeader 	 from '@/Components/UI/PageHeader.svelte'
	import PageMenu   	 from '@/Components/UI/PageMenu.svelte'
	import Section    	 from '@/Components/UI/Section.svelte'
	import SectionBanner from '@/Components/UI/SectionBanner.svelte'
	import Thumbnail     from '@/Components/UI/Thumbnail.svelte'

	const character    = $page.props.character.data
	const customFields = $page.props.customFields.data

	let deletingCharacter = $state(false)
	let editMode = $state(false)

	function toggleEditMode() {
		console.log(editMode, !editMode)
		let value = !editMode
		editMode = value
	}
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
				// { icon: "Pen",   href: route('characters.edit', {character: character.slug}) },
				{ icon: "Pen",   onclick: toggleEditMode },
				{ icon: "Trash", onclick: deleteCharacter, theme: "danger" }
			]}
		/>
	{/snippet}

	{#snippet article()}

		<Section gap={6} size="7xl" class="py-12">

			<ArticleTabs value="details" tabs={[
				{ icon: "UserList",       label: "Details",       value: "details"       },
				{ icon: "Handshake",      label: "Relationships", value: "relationships" },
				{ icon: "FlagBannerFold", label: "Factions",      value: "factions"      },
				{ icon: "Backpack",       label: "Inventory",     value: "items"         },
				{ icon: "MapPinArea",     label: "Location",      value: "location"      },
				{ icon: "ImagesSquare",   label: "Media",         value: "media"         },
				{ icon: "Textbox",        label: "Custom Fields", value: "custom"        }
			]}>
		
				<!-- Details -->
		
				<Tabs.Content value="details">
		
					<ArticleBanner class="relative" image={character.banner?.url}>
						<Heading is="h1" as="h3" class="mt-auto z-10 {character.banner ? 'text-white' : ''}"
							heading={character.name}
							subheading={character.alias}
						/>
						<Thumbnail class="absolute right-12 -bottom-16 w-40" src={character.portrait?.url} />
					</ArticleBanner>
		
					<Heading is="h3" as="h5" heading="Description" class="mt-12 mb-6" />
		
					<p class="font-style-large max-w-[64ch] whitespace-pre-wrap">
						{character.description}
					</p>
			
				</Tabs.Content>
		
		
				<!-- Relationships -->
		
				<Tabs.Content value="relationships">
					<RelationshipsForm
						character={character}
						relationships={character.relationships}
					/>
					<!-- <CharacterGrid /> -->
				</Tabs.Content>
		
		
				<!-- Factions -->
		
				<Tabs.Content value="factions">
					<FactionsForm
						character={character}
						factions={character.factions}
					/>
					<!-- <FactionGrid /> -->
				</Tabs.Content>
		
		
				<!-- Inventory -->
		
				<Tabs.Content value="items">
					<InventoryForm
						character={character}
						items={character.inventory}
					/>
					<!-- <ItemGrid /> -->
				</Tabs.Content>


				<!-- Media -->
		
				<Tabs.Content value="location">
					<LocationForm
						character={character}
						location={character.location}
					/>
					<!-- <Map /> -->
				</Tabs.Content>
		
		
				<!-- Media -->
		
				<Tabs.Content value="media">
					<MediaForm
						character={character}
						media={character.media}
					/>
					<!-- <MediaGrid /> -->
				</Tabs.Content>
		
				
				<!-- Custom Fields -->
		
				<Tabs.Content value="custom">
					<CustomFieldsForm
						fields={customFields}
						values={character.customFieldValues}
					/>
					<!-- <CustomFields /> -->
				</Tabs.Content>
		
			</ArticleTabs>
		</Section>
	
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

<!-- <Modal title="Delete {character.name}?" show={deletingCharacter} onclose={closeModal}>
	<DeleteCharacterForm {character} oncancel={closeModal} />
</Modal> -->