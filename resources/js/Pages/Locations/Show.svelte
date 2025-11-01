<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Flex 		 from '@/Components/Core/Flex.svelte'
	import Grid 		 from '@/Components/Core/Grid.svelte'
	import Inline 		 from '@/Components/Core/Grid.svelte'
	import Stack 		 from '@/Components/Core/Stack.svelte'
	import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
	import Button     	 from '@/Components/UI/Button.svelte'
	import Card     	 from '@/Components/UI/Card.svelte'
	import CardNew       from '@/Components/UI/CardNew.svelte'
	import Chip			 from '@/Components/UI/Chip.svelte'
	import Collapsible	 from '@/Components/UI/Collapsible.svelte'
	import Container	 from '@/Components/UI/Container.svelte'
	import Field    	 from '@/Components/UI/Field.svelte'
	import Heading  	 from '@/Components/UI/Heading.svelte'
	import Icon  		 from '@/Components/UI/Icon.svelte'
	import Media     	 from '@/Components/UI/Media.svelte'
	import MediaGrid     from '@/Components/UI/MediaGrid.svelte'
	import Modal    	 from '@/Components/UI/Modal.svelte'
	import PageHeader 	 from '@/Components/UI/PageHeader.svelte'
	import PageMenu   	 from '@/Components/UI/PageMenu.svelte'
	import Section  	 from '@/Components/UI/Section.svelte'
	import Separator  	 from '@/Components/UI/Separator.svelte'
	import Thumbnail	 from '@/Components/UI/Thumbnail.svelte'
	import Map			 from '@/Components/Features/Location/Map.svelte'


	//	Page props

	import LocationObject from '@/services/LocationObject';
	const location 	   = new LocationObject($page.props.location?.data)
	const customFields = $page.props.customFields?.data

</script>

<svelte:head>
    <title>{location.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet article()}
		<Flex justify="center" gap={12} class="h-full overflow-y-auto py-12">
			<PageMenu
				backTo={route('locations')} backToLabel="Location List"
				items={[
					{ icon: "Info",   		label: "Details",       href: "#details"	},
					{ icon: "Compass",      label: "Map",           href: "#map"		},
					{ icon: "ImagesSquare", label: "Gallery",       href: "#gallery"	},
					{ icon: "Trash", 		label: "Delete", 		onclick: () => location.delete(), theme: "danger" }
				]}
			/>
			<Container size="4xl">


				<!-- Details -->

				<Section id="details" class="pb-6">


					<ArticleBanner>
						<Media
							class="absolute inset-0 rounded-lg overflow-hidden"
							media={location.getBanner()}
							onclick={() => location.openModal('setBanner')}
						/>
						<Media
							class="absolute aspect-square bg-slate-200/50 backdrop-blur hover:backdrop-blur-lg border border-slate-300 text-white right-12 -bottom-16 rounded-lg overflow-hidden w-48 transition-all"
							media={location.getMap()}
							onclick={() => location.openModal('setMap')}
						/>
						{#if location.parent}
							<Inline class="relative">
								<Button style="glass" class="rounded-full"
									icon={location.parent.icon || "ArrowElbowUpLeft"} label={location.parent.name}
									href={route('locations.show', { location: location.parent.slug })}
								/>
							</Inline>
						{/if}
						<Heading is="h1" as="h3"
							class="mt-auto w-3/4 z-10 {location.getBanner() ? 'text-white' : ''}"
							heading={location.name}
							subheading={location.type}
						/>
					</ArticleBanner>

					<Stack class="max-w-[64ch] mx-6 mb-12">
						<Heading is="h3" as="h6" class="mt-9 mb-6">Description</Heading>
						<Collapsible collapsed={true}
							collapsedClass="line-clamp-3 overflow-hidden">
							{location.description}
						</Collapsible>
					</Stack>

					<Stack class="max-w-[64ch] mx-6">
						<Heading is="h3" as="h6" class="mb-6">Custom Fields</Heading>
						{#if location.customFields}
							Custom Fields
						{:else}
							<p class="font-style-placeholder">There aren't any Custom Fields for Locations yet.</p>
						{/if}
					</Stack>
					
				</Section>

				<Separator class="mx-6 my-6 w-[64ch]" />


				<!-- Map -->

				<!-- <pre>{JSON.stringify(location.getMap(),null,3)}</pre> -->

				<Section id="map" class="px-6 py-12">
					<Heading is="h3" as="h6" class="mb-6">Map</Heading>
					{#if location.getMap() || location.mapItems?.length > 0}
						<Map class="aspect-video rounded-lg shadow-lg"
							location={location}
							legend={[
								// { icon: 'UsersThree', 	label: 'Characters', items: location.characters.map(c => ({ ...c, label: c.name })) },
								// { icon: 'Backpack', 	label: 'Items', 	 items: location.characters.map(c => ({ ...c, label: c.name })) },
								{ icon: 'MapPin', label: 'Locations', items: location.mapItems?.map(c => ({ ...c, label: c.name, icon: c.icon || 'MapPin' })) }
							]}
						/>
					{:else}
						<p class="font-style-placeholder">{location.name} doesn't have a map or any child locations yet.</p>
					{/if}
				</Section>

				<Separator class="mx-6 my-6 w-[64ch]" />


				<!-- Points of Interest -->

				<!-- <Section id="points" class="px-6 py-12">
					<Heading is="h3" as="h6" class="mb-6">Points of Interest</Heading>
					{#if location.children.length > 0}
						<Grid cols={3}>
							{#each location.children as loc}
								<Card aspect="video" class="w-full"
									icon={loc.icon || "MapPinArea"}
									image={loc.banner?.url}
									title={loc.name}
									subtitle={loc.type}
									href={route('locations.show', {location: loc.slug})}
								/>
							{/each}
						</Grid>
					{:else}
						<p class="font-style-placeholder">{location.name} doesn't have any points of interest yet.</p>
					{/if}
				</Section> -->


				<!-- Characters -->
		
				<!-- <Section id="characters" class="px-6 py-12">
					<Heading is="h3" as="h6" class="mb-6">Characters</Heading>
					{#if location.characters.length > 0}
						<Grid cols={4} gap={3}>
							{#each location.characters as char}
								<Link
									class="inline-flex gap-3 p-1 rounded-lg w-auto hover:text-accent"
									href={route("characters.show", { character: char.slug})}>
									<Thumbnail
										class="aspect-square bg-neutral-softest rounded h-12 max-w-12"
										icon="User"
										src={char.image?.url}
									/>
									<Stack justify="center">
										<div class="font-bold leading-[1.125rem] line-clamp-1">{char.name}</div>
										<div class="text-sm leading-[1.125rem] line-clamp-1">{char.alias}</div>
									</Stack>
								</Link>
							{/each}
						</Grid>
					{:else}
						<p class="font-style-placeholder">There are no characters at {location.name} yet.</p>
					{/if}
				</Section> -->


				<!-- Gallery -->

				<Section id="gallery" class="px-6 py-12">
					<Heading is="h3" as="h6" class="mb-6">Gallery</Heading>
					<!-- <MediaGrid cols={6}
						media={media_gallery}
						type="gallery"
						addable
					/> -->
				</Section>

			</Container>
		</Flex>
	{/snippet}

</AuthenticatedLayout>