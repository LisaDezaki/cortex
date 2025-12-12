<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Flex 		 from '@/Components/Core/Flex.svelte'
	import Grid 		 from '@/Components/Core/Grid.svelte'
	import Map			 from '@/Components/Core/Map'
	import Stack 		 from '@/Components/Core/Stack.svelte'
	import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
	import Button        from '@/Components/UI/Button.svelte'
	import Card       	 from '@/Components/UI/Card.svelte'
	import CardNew       from '@/Components/UI/CardNew.svelte'
	import Collapsible   from '@/Components/UI/Collapsible.svelte'
	import Container  	 from '@/Components/UI/Container.svelte'
	import Heading    	 from '@/Components/UI/Heading.svelte'
	import Media     	 from '@/Components/UI/Media.svelte'
	import PageMenu   	 from '@/Components/UI/PageMenu.svelte'
	import Section    	 from '@/Components/UI/Section.svelte'
	import Separator     from '@/Components/UI/Separator.svelte'
	import Tag     		 from '@/Components/UI/Tag.svelte'
	import Thumbnail     from '@/Components/UI/Thumbnail.svelte'
	import CharacterObject from '@/services/CharacterObject';
	import url from '@/stores/urlStore'

	/**
	 * Active character instance
	 * @type {CharacterObject}
	 */
	const character    = new CharacterObject($page.props.character?.data)
	const customFields = $page.props.customFields?.data

</script>



<svelte:head>
    <title>{character.name}</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Flex justify="center" gap={12} class="h-full overflow-y-auto px-6 py-12">
			<PageMenu
				backTo={route('characters')} backToLabel="Character List"
				items={[
					{ icon: "Info",         	label: "Details",       href: "#details"       },
					{ icon: "Textbox",          label: "Custom Fields", href: "#custom"        },
					{ icon: "Handshake",        label: "Relationships", href: "#relationships" },
					{ icon: "FlagBannerFold",   label: "Factions",      href: "#factions"      },
					{ icon: "Backpack",         label: "Inventory",     href: "#items"         },
					{ icon: "MapPinSimpleArea", label: "Location",      href: "#location"      },
					{ icon: "ImagesSquare",     label: "Gallery",       href: "#gallery"       },
					{ icon: "Trash", 			label: "Delete", 		onclick: () => character.openModal('delete'), theme: "danger" }
				]}
			/>
			<Container size="3xl">


				<!-- Details -->
			
				<Section id="details" class="pb-6">

					<ArticleBanner>
						<Media
							class="absolute inset-0 aspect-[3/1] bg-slate-200 hover:inner-shadow-lg rounded-lg overflow-hidden text-neutral-softest transition-all w-full"
							media={character.getMedia('banner')}
							onclick={() => character.openModal('setMedia', { type: 'banner', aspect: 'aspect-[7/3]' })}
						/>
						<Media
							class="absolute aspect-square bg-slate-200/50 backdrop-blur hover:backdrop-blur-lg border-2 border-slate-100 hover:inner-shadow-lg right-12 -bottom-16 rounded-lg overflow-hidden text-neutral-softest transition-all w-48"
							media={character.getMedia('portrait')}
							onclick={() => character.openModal('setMedia', { type: 'portrait', aspect: 'aspect-[1/1]' })}
						/>
						<Heading is="h1" as="h3"
							class="max-w-3/4 mt-auto z-10 {character.getMedia('banner') ? 'text-white' : ''}"
							heading={character.name}
							subheading={character.alias}
						/>
					</ArticleBanner>

					<Stack class="max-w-[64ch] mx-6">

						<Heading is="h3" as="h4" class="mt-9 mb-6 text-neutral-softest">Details</Heading>
						
						<Heading is="h3" as="h6" class="mb-6">Description</Heading>
						<Collapsible collapsed={true}
							collapsedClass="line-clamp-3 overflow-hidden">
							{character.description}
						</Collapsible>

						<Heading is="h3" as="h6" class="mt-9 mb-6">Appearance</Heading>
						<Flex wrap class="gap-[2px]">
							{#each character.appearance?.split(',') as tag}
								<Tag plain class="bg-neutral-softest border border-transparent text-neutral px-2 py-1">{tag}</Tag>
							{/each}
							<Button icon="Plus" size="xs" style="plain" theme="accent" class="rounded-full h-7 my-1 w-7" />
						</Flex>
	
						<Heading is="h3" as="h6" class="mt-9 mb-6">Personality</Heading>
						<Flex wrap class="gap-[2px]">
							{#each character.personality?.split(',') as tag}
								<Tag plain class="bg-neutral-softest border border-transparent text-neutral px-2 py-1">{tag}</Tag>
							{/each}
							<Button icon="Plus" size="xs" style="plain" theme="accent" class="rounded-full h-7 my-1 w-7" />
						</Flex>
						
					</Stack>
				</Section>

				<Separator class="mx-6 my-6 w-[64ch]" />


				<!-- Custom Fields -->
		
				<Section id="custom" class="p-6">

					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h4" class="text-neutral-softest">Custom Fields</Heading>
					</Flex>

					{#if customFields && customFields.length > 0}
						{#each customFields as field, i}
							<Flex gap={3} class="max-w-[64ch] py-1.5">
								<span class="font-semibold w-32">{field.label}:</span>
								<span class="line-clamp-1 {character.customFieldValues.find(cfv => cfv.name === field.name) ? '' : 'text-neutral-softest italic'}">{character.customFieldValues.find(cfv => cfv.name === field.name)?.displayValue || "None"}</span>
							</Flex>
						{/each}
						<Flex class="pt-3">
							<Button size="md" style="soft" theme="accent" icon="Plus" iconSize="sm" iconWeight="regular" label="New custom field" onclick={() => {}} />
						</Flex>
					{:else}
						<p class="font-style-placeholder">There are no custom fields for Characters yet.</p>
					{/if}
				</Section>

				<Separator class="max-w-[64ch] mx-6 my-6 w-[64ch]" />
		

				<!-- Relationships -->
		
				<Section id="relationships" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h4" class="text-neutral-softest">Relationships</Heading>
					</Flex>
					<Grid cols={4} gap={6}>
						{#if character.relationships?.items?.length > 0}
							{#each character.relationships.items as rel, i}

								<Link href={route('characters.show', { character: rel.slug })} class="flex items-center gap-3 p-1 w-96 hover:text-accent">
									<Thumbnail class="aspect-square bg-neutral-softest border border-surface w-16"
										icon="User"
										src={rel.image?.url}
									/>
									<Stack class="w-48">
										<div class="font-bold leading-[1.125rem]">{rel.name}</div>
										<div class="text-sm leading-[1.125rem]">{rel.role}</div>
									</Stack>
								</Link>

							{/each}

							<Flex class="p-1.5">
								<Button size="xl" style="soft" theme="accent" icon="Plus" onclick={() => character.openModal('relationship')} class="h-12 rounded-full w-12" />
							</Flex>

						{:else}
							<p class="font-style-placeholder">{character.name} doesn't have any relationships yet.</p>
							<p><button class="text-accent hover:underline" onclick={() => character.openModal('relationship')}>Create one?</button></p>
						{/if}
					</Grid>
				</Section>

				<Separator class="mx-6 my-6 w-[64ch]" />
		
		
				<!-- Factions -->
		
				<Section id="factions" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h4" class="text-neutral-softest">Factions</Heading>
					</Flex>
					{#if character.factions?.items?.length > 0}
						<Grid cols={4} gap={3}>
							{#each character.factions?.items as fac, i}
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
						<p><Link onclick={() => character.addFaction()}>Add one?</Link></p>
					{/if}
				</Section>

				<Separator class="mx-6 my-6 w-[64ch]" />
		
		
				<!-- Inventory -->
		
				<Section id="items" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h4" class="text-neutral-softest">Inventory</Heading>
					</Flex>
					<Grid cols={6} gap={1} class="max-w-[64ch]">
						{#each new Array(12) as item, i}
							<Thumbnail aspect="square"
								class="aspect-square bg-neutral-softest"
							/>
						{/each}
						{#each character.inventory as item, i}
							<Card aspect="square"
								icon="User"
								title={item.name}
								subtitle={item.category}
							/>
						{/each}
						<!-- <CardNew aspect="square"
							onclick={() => {}}
						/> -->
					</Grid>
				</Section>

				<Separator class="mx-6 my-6 w-[64ch]" />


				<!-- Location -->
		
				<Section id="location" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h4" class="text-neutral-softest">Location</Heading>
					</Flex>
					{#if character.mapData?.location}
						<!-- <pre>{JSON.stringify(character.location,null,3)}</pre> -->
						<Map.Context class="aspect-video rounded-lg shadow w-[64ch]"
							location={character?.location}
							navigable={false}
							onUpload={() => character.openModal('location')}
						/>
					{:else}
						<p class="font-style-placeholder">{character.name} hasn't been assigned a location yet.</p>
						<p><Link onclick={() => character.openModal('location')}>Assign one?</Link></p>
					{/if}
				</Section>

				<Separator class="mx-6 my-6 w-[64ch]" />
		
		
				<!-- Media -->
		
				<Section id="gallery" class="px-6 py-12">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h4" class="text-neutral-softest">Gallery</Heading>
					</Flex>
					<!-- <MediaGrid cols={6}
						media={media_gallery}
						type="gallery"
						addable
					/> -->
					<Grid cols={4} class="gap-[2px] max-w-[64ch]">
						{#each new Array(8) as item, i}
							<Thumbnail aspect="square"
								class="aspect-square bg-neutral-softest rounded-none hover:inner-shadow-sm transition-all"
							/>
						{/each}
					</Grid>
				</Section>

				<Separator class="mx-6 my-6 w-[64ch]" />


				<!-- Collections -->
		
				<!-- <Section id="collections" class="p-6">
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
				</Section> -->
				
			</Container>
		</Flex>
	{/snippet}
	
</AuthenticatedLayout>