<script>
	import { page, router } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import DeleteFactionForm from '@/Forms/Faction/Delete.svelte'

	import { Flex, Grid, Stack } from '@/Components/Core'

	import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
	import Button		 from '@/Components/UI/Button.svelte'
	import Card			 from '@/Components/UI/Card.svelte'
	import CardNew       from '@/Components/UI/CardNew.svelte'
	import Chip			 from '@/Components/UI/Chip.svelte'
	import Container	 from '@/Components/UI/Container.svelte'
	import Field    	 from '@/Components/UI/Field.svelte'
	import Heading		 from '@/Components/UI/Heading.svelte'
	import MediaGrid	 from '@/Components/UI/MediaGrid.svelte'
	import Modal		 from '@/Components/UI/Modal.svelte'
	import PageHeader	 from '@/Components/UI/PageHeader.svelte'
	import PageMenu		 from '@/Components/UI/PageMenu.svelte'
	import Section		 from '@/Components/UI/Section.svelte'
	import SetMedia		 from '@/Components/UI/SetMedia.svelte'
	import Thumbnail	 from '@/Components/UI/Section.svelte'

	import Map      	 from '@/Components/Features/Location/Map.svelte'

	const faction 	   = $page.props.faction?.data
	const customFields = $page.props.customFields?.data

	let deletingFaction = $state(false)
	let editMode = $state(false)

	function deleteFaction() {
        deletingFaction = true
    }
	function closeModal() {
		deletingFaction = false
    }

</script>

<svelte:head>
    <title>{faction.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
				{ label: "Factions",   href: route('factions') },
			]}
			back={route('factions')}
			title={faction.name}
			actions={[
				// { icon: "Pen",   href: route('factions.edit', {faction: faction.slug}) },
				// { icon: "Trash", onclick: deleteFaction, theme: "danger" }
			]}
		/>
	{/snippet}

	{#snippet article()}
		<Flex justify="center" gap={12} class="py-12">
			<PageMenu items={[
				{ icon: "Info",      	label: "Details",    	href: "#details"	},
				{ icon: "UsersFour", 	label: "Membership", 	href: "#members"	},
				{ icon: "MapPinArea", 	label: "Headquarters", 	href: "#hq"			},
				{ icon: "ImagesSquare", label: "Gallery",       href: "#gallery" 	},
				{ icon: "Textbox",      label: "Custom Fields", href: "#fields" 	}
			]} />
			<Container size="4xl">

				
				<!-- Details -->
		
				<Section id="details" class="pb-12">
		
					<ArticleBanner class="relative" image={faction.banner?.url}>
						
						<SetMedia
							aspect="aspect-square"
							class="absolute bg-slate-200 border border-slate-300 top-0 left-0 h-full w-full rounded-lg overflow-hidden"
							endpoint={route('factions.update', { faction: faction.slug })}
							method="patch"
							media={faction.banner}
							mediaType="faction_banner"
							requestKey="banner"
							onSuccess={(res) => {
								router.visit(route('factions.show', { faction: faction.slug }), {
									only: ['faction.banner'],
								})
							}}
							onFinish={(req) => {
								console.log('Finish:', req)
							}}
						/>
						<SetMedia
							aspect="aspect-square"
							class="absolute bg-slate-200/10 backdrop-blur hover:backdrop-blur-lg border border-slate-300 text-white right-12 -bottom-24 rounded-lg overflow-hidden w-48 transition-all"
							endpoint={route('factions.update', { faction: faction.slug })}
							method="patch"
							media={faction.emblem}
							mediaType="faction_emblem"
							requestKey="emblem"
							onSuccess={(res) => {
								router.visit(route('factions.show', { faction: faction.slug }), {
									only: ['faction.emblem'],
								})
							}}
							onFinish={(req) => {
								console.log('Finish:', req)
							}}
						/>

						<Heading is="h1" as="h3" class="mt-auto z-10 {faction.emblem ? 'text-white' : ''}"
							heading={faction.name}
							subheading={faction.type}
						/>

					</ArticleBanner>
		
					<Heading is="h3" as="h5" heading="Description" class="mx-6 mt-12 mb-6" />
		
					<p class="max-w-[64ch] mx-6 whitespace-pre-wrap">
						{faction.description}
					</p>
			
				</Section>


				<!-- Membership -->
	
				<Section id="members" class="px-6 py-12">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h5">Membership</Heading>
					</Flex>
					<Stack gap={3}>
						{#each faction.members as member, i}
							<Chip aspect="square"
								icon="User"
								image={member.portrait?.url}
								title={member.name}
								subtitle={member.role}
							/>
						{/each}
						<!-- <CardNew aspect="square"
							onclick={() => {}}
						/> -->
					</Stack>
					<!-- {#if faction.ranks}
						Ranks.Members
					{:else}
						<p class="font-style-placeholder">{faction.name} doesn't have any members yet.</p>
					{/if} -->
					
				</Section>


				<!-- Headquarters -->
	
				<Section id="hq" class="px-6 py-12">
					<Heading is="h3" as="h5" class="mb-6">Headquarters</Heading>
					{#if faction.headquarters}
						Faction: {faction.headquarters}
						<!-- <Map /> -->
					{:else}
						<p class="font-style-placeholder">{faction.name} doesn't have a headquarters yet.</p>
					{/if}
				</Section>


				<!-- Media -->
	
				<Section id="gallery" class="px-6 py-12">
					<Heading is="h3" as="h5" class="mb-6">Gallery</Heading>
					<MediaGrid cols={4} media={[{},{},{},{}]} />
				</Section>


				<!-- Custom Fields -->
	
				<Section id="fields" class="px-6 py-12">
					<Heading is="h3" as="h5" class="mb-6">Custom Field</Heading>
					{#if faction.customFields}
						Custom Fields
						<!-- CustomFields />-->
					{:else}
						<p class="font-style-placeholder">There aren't any Custom Fields for Factions yet.</p>
					{/if}
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

<!-- <Modal title="Delete {faction.name}?" show={deletingFaction} onclose={closeModal}>
	<DeleteFactionForm {faction} oncancel={closeModal} />
</Modal> -->