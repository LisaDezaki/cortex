<script>
	import { page, router } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import DeleteLocationForm from '@/Forms/Location/Delete.svelte'

	import { Flex, Grid, Inline, Stack } from '@/Components/Core'

	import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
	import Button     	 from '@/Components/UI/Button.svelte'
	import Card     	 from '@/Components/UI/Card.svelte'
	import CardNew       from '@/Components/UI/CardNew.svelte'
	import Chip			 from '@/Components/UI/Chip.svelte'
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

	import Map			 from '@/Components/Features/Location/Map.svelte'

	const location 	   = $page.props.location?.data

	let deletingLocation  = $state(false)

	let mediaUploadProps  = $derived({
		endpoint: route('locations.update', { location: location.slug }),
		method: 'patch',
		onSuccess: (res) => {
			router.visit( $page.url, {
				only: ['location.media'],
			})
		}
	})

	let media_banner	= $derived(location.media.filter(m => m.type === 'banner')?.[0])
	let media_map		= $derived(location.media.filter(m => m.type === 'map')?.[0])
	let media_gallery	= $derived(location.media)

	function deleteLocation() {
        deletingLocation  = true
    }
	function closeModal() {
		deletingLocation  = false
    }

</script>

<svelte:head>
    <title>{location.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[{ label: "Locations", href: route('locations') }]}
			back={route('locations')}
			title={location.name}
		/>
	{/snippet}

	{#snippet article()}
		<Flex justify="center" gap={12} class="py-12">

			<PageMenu items={[
				{ icon: "MapPinArea",   	label: "Details",       	href: "#details"	},
				{ icon: "Textbox",      	label: "Custom Fields", 	href: "#custom"		},
				{ icon: "Compass",      	label: "Map",           	href: "#map"		},
				{ icon: "MapPinSimpleArea", label: "Points of Interest", href: "#points"	},
				{ icon: "UsersThree",   	label: "Characters",        href: "#characters"	},
				{ icon: "ImagesSquare", 	label: "Gallery",         	href: "#gallery"	},
				{ icon: "Trash", 			label: "Delete", 			onclick: deleteLocation, theme: "danger" }
			]} />

			<Container size="4xl">

				<!-- Details -->

				<Section id="details" class="pb-12">

					<ArticleBanner>

						<Media replaceable
							aspect="aspect-[7/3]"
							class="absolute inset-0 rounded-lg overflow-hidden"
							media={media_banner}
							type="banner"
							uploadProps={mediaUploadProps}
						/>

						<Media replaceable
							aspect="aspect-square"
							class="absolute aspect-square bg-slate-200/50 backdrop-blur hover:backdrop-blur-lg border border-slate-300 text-white right-12 -bottom-24 rounded-lg overflow-hidden w-48 transition-all"
							media={media_map}
							type="map"
							uploadProps={mediaUploadProps}
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
							class="mt-auto z-10 {media_banner ? 'text-white' : ''}"
							heading={location.name}
							headingClass="whitespace-pre-wrap"
							subheading={location.type}
						/>
					</ArticleBanner>
		
					<Heading is="h3" as="h5" heading="Description" class="mx-6 mt-9 mb-6" />

					<p class="max-w-[64ch] mx-6 whitespace-pre-wrap">
						{location.description}
					</p>
		
				</Section>

				<Section id="fields" class="px-6 py-12">
					<Heading is="h3" as="h5" class="mb-6">Custom Fields</Heading>
					{#if location.customFields}
						Custom Fields
					{:else}
						<p class="font-style-placeholder">There aren't any Custom Fields for Locations yet.</p>
					{/if}
				</Section>

				<Section id="map" class="px-6 py-12">
					<Heading is="h3" as="h5" class="mb-6">Map</Heading>
					{#if media_map || location.children?.length > 0 || location.descendants?.length > 0}
						<Map class="aspect-video rounded-lg" location={location} />
					{:else}
						<p class="font-style-placeholder">{location.name} doesn't have a map or any child locations yet.</p>
					{/if}
				</Section>

				<Section id="points" class="px-6 py-12">
					<Heading is="h3" as="h5" class="mb-6">Points of Interest</Heading>
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
				</Section>
		
				<Section id="characters" class="px-6 py-12">
					<Heading is="h3" as="h5" class="mb-6">Characters</Heading>
					{#if location.characters.length > 0}
						<Grid cols={6}>
							{#each location.characters as character}
								<Card aspect="square" class="w-full"
									icon="User"
									image={character.portrait?.url}
									title={character.name}
									subtitle={character.subtitle}
									href={route('characters.show', {character: character.slug})}
								/>
							{/each}
						</Grid>
					{:else}
						<p class="font-style-placeholder">There are no characters at {location.name} yet.</p>
					{/if}
				</Section>

				<Section id="gallery" class="px-6 py-12">
					<Heading is="h3" as="h5" class="mb-6">Gallery</Heading>
					<MediaGrid cols={6}
						media={media_gallery}
						type="gallery"
						addable
					/>
				</Section>

			</Container>
		</Flex>
	{/snippet}

</AuthenticatedLayout>

<Modal title="Delete {location.name}?" maxWidth="lg" show={deletingLocation} onclose={closeModal}>
	<DeleteLocationForm {location} oncancel={closeModal} />
</Modal>