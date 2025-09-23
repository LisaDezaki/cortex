<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import AuthenticatedLayout 	from '@/Layouts/AuthenticatedLayout.svelte'
	
	import { Flex, Grid, Stack } from '@/Components/Core'

	import Card       	 from '@/Components/UI/Card.svelte'
	import CardNew       from '@/Components/UI/CardNew.svelte'
	import CollectionCard from '@/Components/UI/CollectionCard.svelte'
	import Container  	 from '@/Components/UI/Container.svelte'
	import Heading    	 from '@/Components/UI/Heading.svelte'
	import PageHeader 	 from '@/Components/UI/PageHeader.svelte'
	import Section    	 from '@/Components/UI/Section.svelte'

	const collection    = $page.props.collection?.data

	let addingToCollection = $state(false)

	function addToCollection() {
		addingToCollection = true
	}
	function closeModal() {
		addingToCollection = false
	}

</script>

<svelte:head>
    <title>{collection.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
				{ label: "Characters",	href: route('characters') },
				{ label: "Collections",	href: route('characters.collections') }
			]}
			back={route('characters.collections')}
			title="Collection: {collection.name}" 
		/>
	{/snippet}

	{#snippet article()}
		<Flex justify="center" gap={12} class="py-12">
			<Container size="5xl">


				<!-- Details -->
			
				<Section id="details" class="pb-12">

					<Flex>
						<CollectionCard
							collection={collection}
							class="w-64 h-64 mr-12 flex-shrink-0"
						/>
						<!-- <Thumbnail class="bg-neutral-softest h-64 w-64 rounded-lg" src="/" /> -->
						<Stack>
							<Heading is="h3" as="h4" class="mx-6 mb-6" eyebrowIcon="FolderSimple" eyebrow="Collection">{collection.name}</Heading>
		
							{#if collection.description}
								<p class="max-w-[64ch] mx-6 whitespace-pre-wrap">
									{collection.description}
								</p>
							{:else}
								<p class="max-w-[64ch] mx-6 whitespace-pre-wrap font-style-placeholder">
									No description provided.
								</p>
							{/if}
						</Stack>
					</Flex>

					<!-- <ArticleBanner>

						<Media replaceable
							aspect="aspect-[7/3]"
							class="absolute inset-0 rounded-lg overflow-hidden"
							media={media_banner}
							type="banner"
							uploadProps={mediaUploadProps}
						/>

						<Media replaceable
							aspect="aspect-square"
							class="absolute aspect-square bg-slate-200/50 backdrop-blur hover:backdrop-blur-lg border border-slate-300 text-white right-12 -bottom-16 rounded-lg overflow-hidden w-48 transition-all"
							media={media_portrait}
							type="portrait"
							uploadProps={mediaUploadProps}
						/>
						
						<Heading is="h1" as="h3"
							class="mt-auto z-10 {media_banner ? 'text-white' : ''}"
							heading={character.name}
							headingClass="whitespace-pre-wrap"
							subheading={character.alias}
						/>
					</ArticleBanner> -->
		
					<!-- <Heading is="h3" as="h5" class="mx-6 mt-9 mb-6">Description</Heading>
		
					<p class="max-w-[64ch] mx-6 whitespace-pre-wrap">
						{collection.description}
					</p> -->
			
				</Section>
		

				<!-- Items -->
		
				<Section id="items" class="py-12">

					<Heading is="h3" as="h5" class="mb-6">{collection.items.length} Item{collection.items.length !== 1 ? "s" : ""}</Heading>

					<Grid cols={6} gap={3}>
						{#each collection.items as item, i}
							<Card
								aspect="square"
								image={item.item?.image?.url}
								title={item.item?.name}
								subtitle={item.item?.alias}
							/>
						{/each}
						<CardNew
							aspect="square"
							onclick={addToCollection}
						/>
					</Grid>
				</Section>
				
			</Container>
		</Flex>
	{/snippet}
	
</AuthenticatedLayout>

<!-- <Modal
	title="Add to collection"
	maxWidth="lg"
	show={addingToCollection}
	onclose={closeModal}
>
	<AddToCollectionForm collection={collection} oncancel={closeModal} />
</Modal> -->