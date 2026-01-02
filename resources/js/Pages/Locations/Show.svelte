<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Flex 		 from '@/Components/Core/Flex.svelte'
	import Grid 		 from '@/Components/Core/Grid.svelte'
	import Inline 		 from '@/Components/Core/Inline.svelte'
	import Map 			 from '@/Components/Core/Map'
	import Stack 		 from '@/Components/Core/Stack.svelte'
	import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
	import Button     	 from '@/Components/UI/Button.svelte'
	import Collapsible	 from '@/Components/UI/Collapsible.svelte'
	import Container	 from '@/Components/UI/Container.svelte'
	import Heading  	 from '@/Components/UI/Heading.svelte'
	import Media     	 from '@/Components/UI/Media.svelte'
	import PageMenu   	 from '@/Components/UI/PageMenu.svelte'
	import Section  	 from '@/Components/UI/Section.svelte'
	import Separator  	 from '@/Components/UI/Separator.svelte'
	import Thumbnail  	 from '@/Components/UI/Thumbnail.svelte'
	import LocationObject from '@/services/LocationObject';

	/**
	 * Active location instance
	 * @type {LocationObject}
	 */
	const location 	   = new LocationObject($page.props.location?.data)
	const customFields = $page.props.customFields?.data

</script>



<svelte:head>
    <title>{location.name}</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Flex justify="center" gap={6} class="overflow-y-auto px-20 py-12">
			<PageMenu
				back={{ text: 'Location List', href: route('locations') }}
				items={[
					{ icon: "Info",   		label: "Details",       href: "#details"	},
					{ icon: "Compass",      label: "Map",           href: "#map"		},
					{ icon: "ImagesSquare", label: "Gallery",       href: "#gallery"	},
					{ icon: "Trash", 		label: "Delete", 		onclick: () => location.openModal('delete'), theme: "danger" }
				]}
			/>
			<Container size="3xl">


				<!-- Header -->

				<Section id="header">
					<ArticleBanner>
						<Media
							class="absolute inset-0 rounded-lg overflow-hidden"
							media={location.getMedia('banner')}
							onclick={() => location.openModal('setMedia', { type: 'banner', aspect: 'aspect-[7/3]'})}
						/>
						<Media
							class="absolute aspect-square bg-slate-200/50 backdrop-blur hover:backdrop-blur-lg border border-slate-300 text-white right-12 -bottom-16 rounded-lg overflow-hidden w-48 transition-all"
							media={location.getMedia('map')}
							onclick={() => location.openModal('setMedia', { type: 'map', aspect: 'aspect-[1/1]'})}
						/>
						<!-- {#if location.mapData?.location.name}
							<Inline class="relative">
								<Button style="glass" class="rounded-full"
									icon={location.mapData?.location.icon || "ArrowElbowUpLeft"} text={location.mapData?.location.name}
									href={route('locations.show', { location: location.mapData?.location.slug })}
								/>
							</Inline>
						{/if} -->
						<Inline align="start" justify="start" class="z-10">
							<Heading is="h1" as="h3"
								class="max-w-3/4 mt-auto {location.getMedia('banner') ? 'text-white' : ''}"
								heading={location.name}
								headingClass="whitespace-pre-wrap"
							/>
							<Button class="ml-1.5 rounded-full text-accent" size="xs" style="plain" theme="accent" icon="PencilSimple" onclick={() => location.openModal('rename')} />
						</Inline>
						<Inline class="z-10">{location.type}
							<Button class="ml-1.5 rounded-full text-accent" size="xs" style="plain" theme="accent" icon="PencilSimple" onclick={() => location.openModal('type')} />
						</Inline>
					</ArticleBanner>
				</Section>

				<!-- Details -->

				<Section id="details">
					<Stack class="max-w-[64ch] mx-6 mt-12">
						<Heading is="h3" as="h4" class="mt-9 mb-6">Details</Heading>

						<Heading is="h3" as="h6" class="mb-6 text-neutral-soft">Description
							<Button class="ml-1.5 rounded-full text-accent" size="xs" style="plain" theme="accent" icon="PencilSimple" onclick={() => location.openModal('description')} />
						</Heading>
						{#if location.description}
							<Collapsible collapsed={true}
								collapsedClass="line-clamp-3 overflow-hidden">
								{location.description}
							</Collapsible>
						{:else}
							<span class="text-neutral-softest">No description</span>
						{/if}
					</Stack>
				</Section>

				<Separator class="my-12" />

				<!-- Custom Fields -->
		
				<Section id="custom" class="p-6">
					<Heading is="h3" as="h4" class="mb-6">Custom Fields</Heading>
					{#if customFields && customFields.length > 0}
						<Stack gap={3}>
							{#each customFields as field, i}
								<Flex align="baseline" gap={3}>
									<span class="font-semibold w-32">{field.label}:</span>
									<span class="line-clamp-1 w-32 {character.customFieldValues.find(cfv => cfv.name === field.name) ? '' : 'text-neutral-softest italic'}">{character.customFieldValues.find(cfv => cfv.name === field.name)?.displayValue || "None"}</span>
									<Button class="place-self-start rounded-full"
										size="xs" style="plain" theme="accent" icon="PencilSimple"
										onclick={() => character.openModal('customField', { field: field, value: character.customFieldValues?.find(f => f.name === field.name)?.value })}
									/>
								</Flex>
							{/each}
						</Stack>
					{:else}
						<span class="text-neutral-softer">There are no custom fields for characters in this project yet.</span>
					{/if}
				</Section>

				<Separator class="my-12" />


				<!-- Map -->

				<Section id="map" class="px-6 py-12">
					<Heading is="h3" as="h4" class="mb-6">Map</Heading>
					<Map.Context
						location={location}
						mapItems={location.mapItems.all}
						previewClass="aspect-[3/2] w-full"
					/>
				</Section>

				<Separator class="my-12" />


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
		
				<Section id="gallery" class="p-6">
					<Heading is="h3" as="h4" class="mb-6">Gallery</Heading>
					<Grid cols={6} class="gap-[2px]">
						{#each new Array(6) as item, i}
							<Thumbnail aspect="square"
								class="aspect-square bg-neutral-softest rounded-none hover:inner-shadow-sm transition-all"
							/>
						{/each}
					</Grid>
				</Section>

				<Separator class="my-12" />

			</Container>
		</Flex>
	{/snippet}

</AuthenticatedLayout>