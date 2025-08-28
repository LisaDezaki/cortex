<script>
	import { page, router } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import AuthenticatedLayout 	from '@/Layouts/AuthenticatedLayout.svelte'
	import DeleteCharacterForm 	from '@/Forms/Character/Delete.svelte'
	
	import { Flex, Grid, Stack } from '@/Components/Core'

	import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
	import Button        from '@/Components/UI/Button.svelte'
	import Card       	 from '@/Components/UI/Card.svelte'
	import CardNew       from '@/Components/UI/CardNew.svelte'
	import Chip  	  	 from '@/Components/UI/Chip.svelte'
	import Container  	 from '@/Components/UI/Container.svelte'
	import Field    	 from '@/Components/UI/Field.svelte'
	import Heading    	 from '@/Components/UI/Heading.svelte'
	import MediaGrid     from '@/Components/UI/MediaGrid.svelte'
	import Modal      	 from '@/Components/UI/Modal.svelte'
	import PageHeader 	 from '@/Components/UI/PageHeader.svelte'
	import PageMenu   	 from '@/Components/UI/PageMenu.svelte'
	import Section    	 from '@/Components/UI/Section.svelte'
	import SetMedia    	 from '@/Components/UI/SetMedia.svelte'
	import Thumbnail     from '@/Components/UI/Thumbnail.svelte'

	import Map      	 from '@/Components/Features/Location/Map.svelte'

	const character    = $page.props.character?.data
	const customFields = $page.props.customFields?.data

	let deletingCharacter = $state(false)
	let editMode = $state(false)

	function deleteCharacter() {
        deletingCharacter = true
    }
	function closeModal() {
		deletingCharacter = false
    }
	function toggleEditMode() {
		editMode = !editMode
	}
	function findDisplayValue(fieldId) {
		return character.customFieldValues.find(v => v.customFieldId == fieldId).displayValue || null
	}
	function findValue(fieldId) {
		return character.customFieldValues.find(v => v.customFieldId == fieldId).value || null
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
				// { icon: "Pen",   onclick: toggleEditMode },
				// { icon: "Trash", onclick: deleteCharacter, theme: "danger" }
			]}
		/>
	{/snippet}

	{#snippet article()}
		<Flex justify="center" gap={12} class="py-12">
			<PageMenu items={[
				{ icon: "Info",         	label: "Details",       href: "#details"       },
				{ icon: "Handshake",        label: "Relationships", href: "#relationships" },
				{ icon: "FlagBannerFold",   label: "Factions",      href: "#factions"      },
				{ icon: "Backpack",         label: "Inventory",     href: "#items"         },
				{ icon: "MapPinSimpleArea", label: "Location",      href: "#location"      },
				{ icon: "ImagesSquare",     label: "Gallery",       href: "#gallery"       },
				{ icon: "Textbox",          label: "Custom Fields", href: "#custom"        }
			]} />
			<Container size="4xl">


				<!-- Details -->
			
				<Section id="details" class="pb-12">

					<ArticleBanner class="relative" image={character.banner?.url}>
						
						<SetMedia
							aspect="aspect-square"
							class="absolute bg-slate-200 border border-slate-300 top-0 left-0 h-full w-full rounded-lg overflow-hidden"
							endpoint={route('characters.update', { character: character.slug })}
							method="patch"
							media={character.banner}
							mediaType="character_banner"
							requestKey="banner"
							onSuccess={(res) => {
								router.visit(route('characters.show', { character: character.slug }), {
									only: ['character.banner'],
								})
							}}
							onFinish={(req) => {
								console.log('Finish:', req)
							}}
						/>
						<SetMedia
							aspect="aspect-square"
							class="absolute bg-slate-200/10 backdrop-blur hover:backdrop-blur-lg border border-slate-300 text-white right-12 -bottom-24 rounded-lg overflow-hidden w-48 transition-all"
							endpoint={route('characters.update', { character: character.slug })}
							method="patch"
							media={character.portrait}
							mediaType="character_portrait"
							requestKey="portrait"
							onSuccess={(res) => {
								router.visit(route('characters.show', { character: character.slug }), {
									only: ['character.portrait'],
								})
							}}
							onFinish={(req) => {
								console.log('Finish:', req)
							}}
						/>
						<Heading is="h1" as="h3" class="mt-auto z-10 {character.banner ? 'text-white' : ''}"
							heading={character.name}
							subheading={character.alias}
						/>
					</ArticleBanner>
		
					<Heading is="h3" as="h5" class="mx-6 mt-9 mb-6">Description</Heading>
		
					{#if editMode}
						<Field
							class="max-w-[64ch]"
							type="textarea"
							name="description"
							value={character.description}
							rows={12}
						/>
					{:else}
						<p class="max-w-[64ch] mx-6 whitespace-pre-wrap">
							{character.description}
						</p>
					{/if}
			
				</Section>
		

				<!-- Relationships -->
		
				<Section id="relationships" class="px-6 py-12">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h5">Relationships</Heading>
					</Flex>
					<Stack gap={3}>
						{#each character.relationships as rel, i}

							<Flex align="center" gap={3}>
								<Stack align="end">
									<div class="font-bold">{character.name}</div>
									<div class="text-sm">{rel.parentRole}</div>
								</Stack>
								<Flex align="center" class="-space-x-6">
									<Thumbnail class="aspect-square bg-slate-200 rounded-full w-12"
										src={character.portrait?.url}
									/>
									<Thumbnail class="aspect-square bg-slate-200 rounded-full w-12"
										src={rel.portrait?.url}
									/>
								</Flex>
								<Stack>
									<div class="font-bold">{rel.name}</div>
									<div class="text-sm">{rel.role}</div>
								</Stack>
							</Flex>
							<!-- <Chip aspect="square"
								icon="User"
								image={character.portrait?.url}
								title={character.name}
								subtitle={rel.parentRole}
							/>
							<Chip aspect="square"
								icon="User"
								image={rel.portrait?.url}
								title={rel.name}
								subtitle={rel.role}
							/> -->
						{/each}
					</Stack>
				</Section>
		
		
				<!-- Factions -->
		
				<Section id="factions" class="px-6 py-12">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h5">Factions</Heading>
					</Flex>
					<Grid cols={8}>
						{#each character.factions as fac, i}
							<Card aspect="square"
								icon="User"
								title={fac.name}
								subtitle={fac}
							/>
						{/each}
						<CardNew aspect="square"
							onclick={() => {}}
						/>
					</Grid>
					<!-- <FactionsForm
						character={character}
						factions={character.factions}
					/> -->
					<!-- <FactionGrid /> -->
				</Section>
		
		
				<!-- Inventory -->
		
				<Section id="items" class="px-6 py-12">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h5">Inventory</Heading>
					</Flex>
					<Grid cols={8}>
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
		
		
				<!-- Location -->
		
				<Section id="location" class="px-6 py-12">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h5">Location</Heading>
					</Flex>
					{#if location}
						<Map class="aspect-video rounded-lg w-full"
							location={character.location}
						/>
					{:else}
						<p class="font-style-placeholder">{character.name} hasn't been assigned a location yet.</p>
					{/if}
					<!-- <LocationForm
						character={character}
						location={character.location}
					/> -->
					<!-- <Map /> -->
				</Section>
		
		
				<!-- Media -->
		
				<Section id="gallery" class="px-6 py-12">
					<Heading is="h3" as="h5" class="mb-6">Gallery</Heading>
					<MediaGrid cols={4} media={[{},{},{},{}]} />
				</Section>
		
				
				<!-- Custom Fields -->
		
				<Section id="custom" class="px-6 py-12">

					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h5">Custom Fields</Heading>
					</Flex>

					{#if customFields && customFields.length > 0}
						{#each customFields as field, i}

							{#if editMode}
								<Field layout="block" inputClass="w-full" {...field} />

							{:else}
								<Flex gap={3}>
									<span class="font-bold w-20">{field.label}:</span>
									<span class="line-clamp-1 {findDisplayValue(field.id) ? '' : 'font-style-placeholder'}">{findDisplayValue(field.id) || "undefined"}</span>
								</Flex>

							{/if}
						{/each}
						
					{:else}
						<p class="font-style-placeholder">There are no custom fields for Characters yet.</p>
						
					{/if}
					<!-- <CustomFieldsForm
						fields={customFields}
						values={character.customFieldValues}
					/> -->
				</Section>
				
			</Container>
		</Flex>
	{/snippet}
	
</AuthenticatedLayout>

<!-- <Modal title="Delete {character.name}?" show={deletingCharacter} onclose={closeModal}>
	<DeleteCharacterForm {character} oncancel={closeModal} />
</Modal> -->