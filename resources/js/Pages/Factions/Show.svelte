<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import { Flex, Grid, Stack } from '@/Components/Core'

	import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
	import Button        from '@/Components/UI/Button.svelte'
	import Card       	 from '@/Components/UI/Card.svelte'
	import CardNew       from '@/Components/UI/CardNew.svelte'
	import Collapsible	 from '@/Components/UI/Collapsible.svelte'
	import Container	 from '@/Components/UI/Container.svelte'
	import Heading		 from '@/Components/UI/Heading.svelte'
	import Media     	 from '@/Components/UI/Media.svelte'
	import MediaGrid	 from '@/Components/UI/MediaGrid.svelte'
	import PageHeader	 from '@/Components/UI/PageHeader.svelte'
	import PageMenu		 from '@/Components/UI/PageMenu.svelte'
	import Section		 from '@/Components/UI/Section.svelte'
	import Separator	 from '@/Components/UI/Separator.svelte'
	import Thumbnail	 from '@/Components/UI/Thumbnail.svelte'

	import Map      	 from '@/Components/Features/Location/Map.svelte'

	const faction 	   = $page.props.faction?.data
	const customFields = $page.props.customFields?.data

	let media_banner	= $derived(faction.media.filter(m => m.type === 'banner')?.[0])
	let media_emblem	= $derived(faction.media.filter(m => m.type === 'emblem')?.[0])
	let media_gallery	= $derived(faction.media)

	
	/**
	 * Modal Management
	 */

	import { modalActions } from '@/stores/modalStore';

    function deleteFaction(fac) { modalActions.open('deleteFaction', 		{ faction: faction 	}) }
	function addMember(fac)		{ modalActions.open('addFactionMember', 	{ faction: faction	}) }

</script>

<svelte:head>
    <title>{faction.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader title={faction.name} />
	{/snippet}

	{#snippet article()}
		<Flex justify="center" gap={12} class="py-12">
			<PageMenu items={[
				{ icon: "Info",      	label: "Details",    	href: "#details"	},
				{ icon: "Textbox",      label: "Custom Fields", href: "#fields" 	},
				{ icon: "MapPinArea", 	label: "Headquarters", 	href: "#hq"			},
				{ icon: "UsersFour", 	label: "Membership", 	href: "#members"	},
				{ icon: "ImagesSquare", label: "Gallery",       href: "#gallery" 	},
				{ icon: "Trash", 		label: "Delete",		onclick: deleteFaction, theme: "danger" }
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
							endpoint={route('factions.update', { faction: faction.slug })}
							method={'patch'}
							reloadPageProps={['factions.media']}
						/>
						<Media replaceable
							aspect="aspect-square"
							class="absolute aspect-square bg-slate-200/50 backdrop-blur hover:backdrop-blur-lg border border-slate-300 text-white right-12 -bottom-16 rounded-lg overflow-hidden w-48 transition-all"
							media={media_emblem}
							type="emblem"
							endpoint={route('factions.update', { faction: faction.slug })}
							method={'patch'}
							reloadPageProps={['factions.media']}
						/>
						<Heading is="h1" as="h3"
							class="mt-auto z-10 {faction.banner ? 'text-white' : ''}"
							heading={faction.name}
							headingClass="whitespace-pre-wrap"
							subheading={faction.type}
						/>
					</ArticleBanner>
		
					<Heading is="h3" as="h6" class="mx-6 mt-9 mb-6">Description</Heading>

					<Collapsible collapsed={true}
						class="max-w-[64ch] mx-6"
						collapsedClass="line-clamp-4 overflow-hidden">
						{faction.description}
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
						<p class="font-style-placeholder">There are no custom fields for Factions yet.</p>
					{/if}
				</Section>

				<Separator class="mx-6 my-6 w-96" />


				<!-- Headquarters -->
	
				<Section id="hq" class="px-6 py-12">
					<Heading is="h3" as="h6" class="mb-6">Headquarters</Heading>
					{#if faction.headquarters}

						<!-- <pre>{JSON.stringify(faction.headquarters,null,3)}</pre> -->
						
						<!-- <Thumbnail src={faction.headquarters?.image?.url} class="max-h-[32ch] max-w-[64ch] mb-3 rounded-lg" /> -->

						<!-- {#if faction.headquarters?.parent}
							<p>
								<Link href={route('locations.show', { location: faction.headquarters?.slug        })}>{faction.headquarters?.name}</Link>,
								<Link href={route('locations.show', { location: faction.headquarters?.parent.slug })}>{faction.headquarters?.parent.name}</Link>
							</p>
						{/if} -->
						
						<!-- <Map /> -->
						 <Map class="aspect-[2/1] max-w-[75%] rounded-lg" location={faction.headquarters?.parent} />

					{:else}
						<p class="font-style-placeholder">{faction.name} doesn't have a headquarters yet.</p>
					{/if}
				</Section>

				<Separator class="mx-6 my-6 w-96" />


				<!-- Membership -->

				<Section id="members" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h6">Membership</Heading>
					</Flex>
					<Grid cols={4} gap={3}>
						{#each faction.members as member, i}
							<Link
								class="inline-flex gap-3 p-1 rounded-lg w-auto hover:text-accent"
								href={route("characters.show", { character: member.slug})}>
								<Thumbnail
									class="aspect-square bg-neutral-softest rounded h-12 max-w-12"
									icon="User"
									src={member.image?.url}
								/>
								<Stack justify="center">
									<div class="font-bold leading-[1.125rem] line-clamp-1">{member.name}</div>
									<div class="text-sm leading-[1.125rem] line-clamp-1">{member.rank.name}</div>
								</Stack>
							</Link>
						{/each}
					</Grid>
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
	
			</Container>
	
			<!-- <Stack gap={12}>
				<Section id="#details">
					<Heading is="h2" as="h3" class="my-12"
						eyebrowIcon="FlagBannerFold" eyebrow="Faction"
						heading={faction.name}
						subheading={faction.type}
					/>
					<p>{faction.description}</p>
				</Section>
	
				{#if faction.ranks.length > 0}
					<Section id="membership">
						<Heading is="h4" as="h6" class="mb-6"
							heading="Membership"
						/>
						{#each faction.ranks as rank}
							<span class="bg-slate-500/10 font-style-large px-2 py-1 rounded-full">
								{rank.name}
							</span>
							<Grid cols={6} class="mt-2">
								{#each faction.members.filter(m => m.rank.id == rank.id) as member}
									<Card
										aspect="square"
										title={member.name}
										subtitle={member.rank.name}
										icon="User"
										image={member.portrait?.url}
										href={route('characters.show', {character: member.slug})}
									/>
								{/each}
							</Grid>
						{/each}
					</Section>
				{/if}
			</Stack> -->
			
		</Flex>
	{/snippet}
	
</AuthenticatedLayout>

<!-- <DeleteFactionForm isOpen={deletingFaction} faction={faction}
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['factions']}
/> -->