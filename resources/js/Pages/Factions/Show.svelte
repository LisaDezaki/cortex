<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Flex 		 from '@/Components/Core/Flex.svelte'
	import Grid 		 from '@/Components/Core/Grid.svelte'
	import Inline 		 from '@/Components/Core/Inline.svelte'
	import Stack 		 from '@/Components/Core/Stack.svelte'
	import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
	import Button        from '@/Components/UI/Button.svelte'
	import Card       	 from '@/Components/UI/Card.svelte'
	import CardNew       from '@/Components/UI/CardNew.svelte'
	import Collapsible	 from '@/Components/UI/Collapsible.svelte'
	import Container	 from '@/Components/UI/Container.svelte'
	import Heading		 from '@/Components/UI/Heading.svelte'
	import Icon		 	 from '@/Components/UI/Icon.svelte'
	import Media     	 from '@/Components/UI/Media.svelte'
	import PageMenu		 from '@/Components/UI/PageMenu.svelte'
	import Section		 from '@/Components/UI/Section.svelte'
	import Separator	 from '@/Components/UI/Separator.svelte'
	import Tag	 		 from '@/Components/UI/Tag.svelte'
	import Thumbnail	 from '@/Components/UI/Thumbnail.svelte'
	import Map      	 from '@/Components/Features/Location/Map.svelte'


	//	Page props

	import FactionObject from '@/services/FactionObject';
	const faction 	   = new FactionObject($page.props.faction?.data)
	const customFields = $page.props.customFields?.data

	function findDisplayValue(fieldId) {
		return character.customFieldValues?.find(v => v.customFieldId == fieldId)?.displayValue || null
	}

</script>



<svelte:head>
    <title>{faction.name}</title>
</svelte:head>



<AuthenticatedLayout>

	<!-- {#snippet header()}
		<PageHeader title={faction.name} />
	{/snippet} -->

	{#snippet article()}
		<Flex justify="center" gap={12} class="py-12">
			<PageMenu
				backTo={route('characters')} backToLabel="Character List"
				items={[
					{ icon: "Info",      	label: "Details",    	href: "#details"	},
					{ icon: "UsersFour", 	label: "Membership", 	href: "#members"	},
					{ icon: "ImagesSquare", label: "Gallery",       href: "#gallery" 	},
					{ icon: "Trash", 		label: "Delete",		onclick: () => faction.delete(), theme: "danger" }
				]}
			/>
			<Container size="4xl">

				
				<!-- Details -->
		
				<Section id="details" class="pb-6">

					<ArticleBanner>
						<Media
							class="absolute inset-0 aspect-[3/1] rounded-lg overflow-hidden"
							media={faction.getBanner()}
							onclick={() => faction.openModal('setBanner')}
						/>
						<Media
							class="absolute aspect-square bg-slate-200/50 backdrop-blur hover:backdrop-blur-lg border border-slate-300 text-white right-12 -bottom-16 rounded-lg overflow-hidden w-48 transition-all"
							media={faction.getEmblem()}
							onclick={() => faction.openModal('setEmblem')}
						/>
						<Heading is="h1" as="h3"
							class="mt-auto w-3/4 z-10 {faction.getBanner() ? 'text-white' : ''}"
							heading={faction.name}
							headingClass="whitespace-pre-wrap"
							subheading={faction.type}
						/>
					</ArticleBanner>

					<Stack gap={6} class="p-6">

						<Grid cols={3} gap={6} class="w-3/4">
							<Stack gap={1.5}>
								<Inline class="font-light px-1.5 text-neutral-soft text-sm" gap={1.5}>
									<Icon name="MapPin" size="sm" />
									<span>Headquarters
								</Inline>

								{#if faction.headquarters}
									<Link
										class="bg-white border border-neutral-softest inline-flex gap-3 p-1 rounded-lg w-auto hover:bg-accent-softest hover:border-accent-softest hover:text-accent"
										href={route("locations.show", { location: faction.headquarters?.slug})}>
										<Thumbnail
											class="aspect-square bg-neutral-softest rounded h-11 max-w-11"
											icon="User"
											src={faction.headquarters.image?.url}
										/>
										<Stack justify="center">
											<div class="font-bold leading-[1.125rem] line-clamp-1">{faction.headquarters.name}</div>
											<div class="text-sm leading-[1.125rem] line-clamp-1">{faction.headquarters.type}</div>
										</Stack>
									</Link>
								{:else}
									<p class="font-style-placeholder">There is no headquarters for this Faction yet.</p>
								{/if}

							</Stack>

							<Stack gap={1.5}>
								<Inline class="font-light text-neutral-soft text-sm" gap={1.5}>
									<Icon name="UsersFour" size="sm" />
									<span>Membership
								</Inline>

								<!-- {#if faction.headquarters}
									<Link
										class="inline-flex gap-3 p-1 rounded-lg w-auto hover:text-accent"
										href={route("locations.show", { location: faction.headquarters?.slug})}>
										<Thumbnail
											class="aspect-square bg-neutral-softest rounded h-11 max-w-11"
											icon="User"
											src={faction.headquarters.image?.url}
										/>
										<Stack justify="center">
											<div class="font-bold leading-[1.125rem] line-clamp-1">{faction.headquarters.name}</div>
											<div class="text-sm leading-[1.125rem] line-clamp-1">{faction.headquarters.type}</div>
										</Stack>
									</Link>
								{:else}
									<p class="font-style-placeholder">There is no headquarters for this Faction yet.</p>
								{/if} -->

							</Stack>
						</Grid>

						<Heading is="h3" as="h6" class="mt-9">Description</Heading>

						<Collapsible collapsed={true}
							class="max-w-[64ch]"
							collapsedClass="line-clamp-3 overflow-hidden">
							{faction.description}
						</Collapsible>

						<!-- <Heading is="h3" as="h6" class="mt-9">Headquarters</Heading>
						{#if faction.headquarters}
							<Link
								class="inline-flex gap-3 p-1 rounded-lg w-auto hover:text-accent"
								href={route("locations.show", { location: faction.headquarters?.slug})}>
								<Thumbnail
									class="aspect-square bg-neutral-softest rounded h-12 max-w-12"
									icon="User"
									src={faction.headquarters.image?.url}
								/>
								<Stack justify="center">
									<div class="font-bold leading-[1.125rem] line-clamp-1">{faction.headquarters.name}</div>
									<div class="text-sm leading-[1.125rem] line-clamp-1">{faction.headquarters.type}</div>
								</Stack>
							</Link>
						{:else}
							<p class="font-style-placeholder">There is no headquarters for this Faction yet.</p>
						{/if} -->
	
						<Heading is="h3" as="h6" class="mt-9">Custom Fields</Heading>
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
					</Stack>
		
				</Section>

				<Separator class="mx-6 my-6 w-[64ch]" />


				<!-- Headquarters -->
	
				<!-- <Section id="hq" class="px-6 py-12">
					<Heading is="h3" as="h6" class="mb-6">Headquarters</Heading>
					{#if faction.headquarters} -->

						<!-- <pre>{JSON.stringify(faction.headquarters,null,3)}</pre> -->
						
						<!-- <Thumbnail src={faction.headquarters?.image?.url} class="max-h-[32ch] max-w-[64ch] mb-3 rounded-lg" /> -->

						<!-- {#if faction.headquarters?.parent}
							<p>
								<Link href={route('locations.show', { location: faction.headquarters?.slug        })}>{faction.headquarters?.name}</Link>,
								<Link href={route('locations.show', { location: faction.headquarters?.parent.slug })}>{faction.headquarters?.parent.name}</Link>
							</p>
						{/if} -->
						
						<!-- <Map /> -->
						 <!-- <Map class="aspect-[2/1] max-w-[64ch] rounded-lg" location={faction.headquarters} /> -->

					<!-- {:else}
						<p class="font-style-placeholder">{faction.name} doesn't have a headquarters yet.</p>
					{/if}
				</Section> -->

				<!-- <Separator class="mx-6 my-6 w-[64ch]" /> -->


				<!-- Membership -->

				<Section id="members" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h6">Membership</Heading>
					</Flex>
					<Grid cols={4} gap={3}>
						{#each faction.members?.items as member, i}
							<Link
								class="inline-flex gap-3 p-1 rounded-lg w-auto hover:text-accent"
								href={route("characters.show", { character: member.slug})}>
								<Thumbnail
									class="aspect-square bg-neutral-softest rounded h-11 max-w-11"
									icon="User"
									src={member.image?.url}
								/>
								<Stack justify="center">
									<div class="font-bold leading-[1.125rem] line-clamp-1">{member.name}</div>
									<div class="text-sm leading-[1.125rem] line-clamp-1">{member.rank?.name}</div>
								</Stack>
							</Link>
						{/each}
					</Grid>
				</Section>

				<Separator class="mx-6 my-6 w-[64ch]" />


				<!-- Media -->
	
				<Section id="gallery" class="px-6 py-12">
					<Heading is="h3" as="h6" class="mb-6">Gallery</Heading>
					<!-- <MediaGrid cols={6}
						media={media_gallery}
						type="gallery"
						addable
					/> -->
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