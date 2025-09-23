<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import AuthenticatedLayout 	from '@/Layouts/AuthenticatedLayout.svelte'
	
	import { Flex, Grid, Stack } from '@/Components/Core'

	import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
	import Button        from '@/Components/UI/Button.svelte'
	import Card       	 from '@/Components/UI/Card.svelte'
	import CardNew       from '@/Components/UI/CardNew.svelte'
	import Collapsible   from '@/Components/UI/Collapsible.svelte'
	import Container  	 from '@/Components/UI/Container.svelte'
	import Field    	 from '@/Components/UI/Field.svelte'
	import Heading    	 from '@/Components/UI/Heading.svelte'
	import Media     	 from '@/Components/UI/Media.svelte'
	import MediaGrid     from '@/Components/UI/MediaGrid.svelte'
	import PageHeader 	 from '@/Components/UI/PageHeader.svelte'
	import PageMenu   	 from '@/Components/UI/PageMenu.svelte'
	import Section    	 from '@/Components/UI/Section.svelte'
	import Separator     from '@/Components/UI/Separator.svelte'
	import Thumbnail     from '@/Components/UI/Thumbnail.svelte'

	import Map      	 from '@/Components/Features/Location/Map.svelte'

	const character    = $page.props.character?.data
	const customFields = $page.props.customFields?.data

	let media_banner	= $derived(character.media?.filter(m => m.type === 'banner')?.[0])
	let media_portrait	= $derived(character.media?.filter(m => m.type === 'portrait')?.[0])
	let media_gallery	= $derived(character.media)


	/**
	 * Modal Management
	 */

	import { modalActions } from '@/stores/modalStore';
    function deleteCharacter(c) { modalActions.open('deleteCharacter', 			{ character: character 	}) }
    function addRelationship(c) { modalActions.open('setCharacterRelationship', { character: character 	}) }
    function setFaction(c)		{  }
    function setLocation(c)		{  }

	function findDisplayValue(fieldId) {
		return character.customFieldValues?.find(v => v.customFieldId == fieldId)?.displayValue || null
	}

</script>

<svelte:head>
    <title>{character.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader title={character.name} />
	{/snippet}

	{#snippet article()}
		<Flex justify="center" gap={12} class="py-12">
			<PageMenu items={[
				{ icon: "Info",         	label: "Details",       href: "#details"       },
				{ icon: "Textbox",          label: "Custom Fields", href: "#custom"        },
				{ icon: "Handshake",        label: "Relationships", href: "#relationships" },
				{ icon: "FlagBannerFold",   label: "Factions",      href: "#factions"      },
				{ icon: "Backpack",         label: "Inventory",     href: "#items"         },
				{ icon: "MapPinSimpleArea", label: "Location",      href: "#location"      },
				{ icon: "ImagesSquare",     label: "Gallery",       href: "#gallery"       },
				{ icon: "FolderSimple",     label: "Collections",  	href: "#collections"   },
				{ icon: "Trash", 			label: "Delete", 		onclick: deleteCharacter, theme: "danger" }
			]} />
			<Container size="4xl">


				<!-- Details -->
			
				<Section id="details" class="pb-6">

					<ArticleBanner>
						<Media replaceable
							aspect="aspect-[3/1]"
							class="absolute inset-0 rounded-lg overflow-hidden shadow-md"
							media={media_banner}
							type="banner"
							endpoint={route('characters.update', { character: character.slug })}
							method={'patch'}
							reloadPageProps={['characters.media', 'character.media']}
						/>
						<Media replaceable
							aspect="aspect-square"
							class="absolute aspect-square bg-slate-200/50 backdrop-blur hover:backdrop-blur-lg border border-slate-300 text-white right-12 -bottom-16 rounded-lg overflow-hidden w-48 shadow-md transition-all"
							media={media_portrait}
							type="portrait"
							endpoint={route('characters.update', { character: character.slug })}
							method={'patch'}
							reloadPageProps={['characters.media', 'character.media']}
						/>
						<Heading is="h1" as="h3"
							class="mt-auto z-10 {media_banner ? 'text-white' : ''}"
							heading={character.name}
							headingClass="whitespace-pre-wrap"
							subheading={character.alias}
						/>
					</ArticleBanner>

					<Heading is="h3" as="h6" class="mx-6 mt-9 mb-6">Description</Heading>

					<Collapsible collapsed={true}
						class="max-w-[64ch] mx-6"
						collapsedClass="line-clamp-4 overflow-hidden">
						{character.description}
					</Collapsible>

				</Section>

				<Separator class="mx-6 my-6 w-96" />


				<!-- Custom Fields -->
		
				<Section id="custom" class="p-6">

					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h6">Custom Fields</Heading>
					</Flex>

					{#if customFields && customFields.length > 0}
						{#each customFields as field, i}
							<Flex gap={3}>
								<span class="font-bold w-20">{field.label}:</span>
								<span class="line-clamp-1 {findDisplayValue(field.id) ? '' : 'font-style-placeholder'}">{findDisplayValue(field.id) || "undefined"}</span>
							</Flex>
						{/each}
					{:else}
						<p class="font-style-placeholder">There are no custom fields for Characters yet.</p>
					{/if}
				</Section>

				<Separator class="mx-6 my-6 w-96" />
		

				<!-- Relationships -->
		
				<Section id="relationships" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h6">Relationships</Heading>
					</Flex>
					<Stack gap={0}>
						{#if character.relationships?.length > 0}
							{#each character.relationships as rel, i}

								<Flex align="center" gap={3} class="p-1.5 w-96">
									<Stack align="end" class="w-48">
										<div class="font-bold leading-[1.125rem]">{character.name}</div>
										<div class="text-sm leading-[1.125rem]">{rel.parentRole}</div>
									</Stack>
									<Flex align="center" class="-space-x-6">
										<Thumbnail
											class="aspect-square bg-surface border border-surface rounded-full w-12"
											src={character.image?.url}
										/>
										<Thumbnail class="aspect-square bg-surface border border-surface rounded-full w-12"
											src={rel.image?.url}
										/>
									</Flex>
									<Stack class="w-48">
										<div class="font-bold leading-[1.125rem]">{rel.name}</div>
										<div class="text-sm leading-[1.125rem]">{rel.role}</div>
									</Stack>
								</Flex>

							{/each}

							<Flex justify="center" class="mt-3 w-96">
								<Button style="soft" theme="accent" onclick={addRelationship}>Add another relationship?</Button>
							</Flex>

						{:else}
							<p class="font-style-placeholder">{character.name} doesn't have any relationships yet.</p>
							<p><button class="text-accent hover:underline" onclick={addRelationship}>Create one?</button></p>
						{/if}
					</Stack>
				</Section>

				<Separator class="mx-6 my-6 w-96" />
		
		
				<!-- Factions -->
		
				<Section id="factions" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h6">Factions</Heading>
					</Flex>
					{#if character.factions.length > 0}
						<Grid cols={4} gap={3}>
							{#each character.factions as fac, i}
								<Link
									class="inline-flex gap-3 p-1 rounded-lg w-auto hover:text-accent"
									href={route("factions.show", { faction: fac.slug})}>
									<Thumbnail
										class="aspect-square bg-neutral-softest rounded h-16 max-w-16"
										icon="FlagBannerFold"
										src={fac.image?.url}
									/>
									<Stack justify="center">
										<div class="font-bold leading-[1.125rem] line-clamp-1">{fac.name}</div>
										<div class="text-sm leading-[1.125rem] line-clamp-1">{fac.type}</div>
									</Stack>
								</Link>
							{/each}
						</Grid>
					{:else}
						<p class="font-style-placeholder">{character.name} isn't in any factions yet.</p>
						<p><Link onclick={setFaction}>Add one?</Link></p>
					{/if}
				</Section>

				<Separator class="mx-6 my-6 w-96" />
		
		
				<!-- Inventory -->
		
				<Section id="items" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h6">Inventory</Heading>
					</Flex>
					<Grid cols={6}>
						{#each character.inventory as item, i}
							<Card aspect="square"
								icon="User"
								title={item.name}
								subtitle={item.category}
							/>
						{/each}
						<CardNew aspect="square"
							onclick={() => {}}
						/>
					</Grid>
					<!-- <InventoryForm
						character={character}
						items={character.inventory}
					/> -->
					<!-- <ItemGrid /> -->
				</Section>

				<Separator class="mx-6 my-6 w-96" />
		
		
				<!-- Location -->
		
				<Section id="location" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h6">Location</Heading>
					</Flex>
					{#if character.location}
						<Map class="aspect-video rounded-lg shadow w-full"
							location={character.location}
						/>
					{:else}
						<p class="font-style-placeholder">{character.name} hasn't been assigned a location yet.</p>
						<p><Link onclick={setLocation}>Assign one?</Link></p>
					{/if}
				</Section>

				<Separator class="mx-6 my-6 w-96" />
		
		
				<!-- Media -->
		
				<Section id="gallery" class="px-6 py-12">
					<Heading is="h3" as="h6" class="mb-6">Gallery</Heading>
					<MediaGrid cols={6}
						media={media_gallery}
						type="gallery"
						addable
					/>
				</Section>

				<Separator class="mx-6 my-6 w-96" />


				<!-- Collections -->
		
				<Section id="collections" class="p-6">
					<Stack class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h6">Collections</Heading>
					</Stack>
					<Grid cols={6}>
						{#each character.collections as collection, i}
							<Card aspect="square"
								icon="FolderSimple"
								href={route("collections.show", { collection: collection.slug })}
								title={collection.name}
								subtitle={collection.items_count}
							/>
						{/each}
						<CardNew aspect="square"
							onclick={() => {}}
						/>
					</Grid>
				</Section>
				
			</Container>
		</Flex>
	{/snippet}
	
</AuthenticatedLayout>