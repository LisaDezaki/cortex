<script>
	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Flex 		 from '@/Components/Core/Flex.svelte'
	import Form 		 from '@/Components/Core/Form.svelte'
	import Grid 		 from '@/Components/Core/Grid.svelte'
	import Inline 		 from '@/Components/Core/Inline.svelte'
	import Map			 from '@/Components/Core/Map'
	import Stack 		 from '@/Components/Core/Stack.svelte'
	import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
	import Button        from '@/Components/UI/Button.svelte'
	import Card       	 from '@/Components/UI/Card.svelte'
	import CardNew       from '@/Components/UI/CardNew.svelte'
	import Collapsible   from '@/Components/UI/Collapsible.svelte'
	import Container  	 from '@/Components/UI/Container.svelte'
	import Entity    	 from '@/Components/UI/Entity.svelte'
	import Field    	 from '@/Components/UI/Field.svelte'
	import Heading    	 from '@/Components/UI/Heading.svelte'
	import Input    	 from '@/Components/UI/Input'
	import Media     	 from '@/Components/UI/Media.svelte'
	import PageMenu   	 from '@/Components/UI/PageMenu.svelte'
	import Section    	 from '@/Components/UI/Section.svelte'
	import Separator     from '@/Components/UI/Separator.svelte'
	import Tag     		 from '@/Components/UI/Tag.svelte'
	import Thumbnail     from '@/Components/UI/Thumbnail.svelte'
	import CharacterObject from '@/services/CharacterObject';
	import url from '@/stores/urlStore'
    import { onMount } from 'svelte'

	/**
	 * Active character instance
	 * @type {CharacterObject}
	 */
	const character    = new CharacterObject($page.props.character?.data)
	const customFields = $page.props.customFields?.data

	// let customFieldForm = useForm({ customFields: customFields.reduce((acc,curr) => {
	// 	acc[curr.id] = character.customFieldValues?.find(cfv => cfv.fieldId === curr.id)?.value || null
	// 	return acc
	// }, {})})

	let customFieldForm = useForm({
		customFields: customFields.map((field) => ({
			id: field.id,
			value: character.customFieldValues?.find(cfv => cfv.fieldId === field.id)?.value || null
		}))
	})

	function submitCustomFields() {
		$customFieldForm.patch(character.routes.update, {})
	}

	// onMount(() => {
	// 	customFields.forEach(cf => {
	// 		$customFieldForm[cf.id] = character.customFieldValues?.find(cfv => cfv.fieldId === cf.id)?.value || null
	// 	})
	// })

</script>



<svelte:head>
    <title>{character.name}</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Flex justify="center" gap={12} class="overflow-y-auto px-20 py-12">

			<!-- Page Menu -->

			<PageMenu
				back={{ text: 'Character List', href: route('characters') }}
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

				<!-- Header -->

				<Section id="header">
					<ArticleBanner>
						<Media
							class="absolute inset-0 aspect-[3/1] bg-slate-200 rounded-lg overflow-hidden"
							media={character.getMedia('banner')}
							onclick={() => character.openModal('setMedia', { type: 'banner', aspect: 'aspect-[7/3]' })}
						/>
						<Media
							class="absolute aspect-square bg-slate-200/50 backdrop-blur hover:backdrop-blur-lg border-2 border-slate-100 right-12 -bottom-16 rounded-lg overflow-hidden w-48"
							media={character.getMedia('portrait')}
							onclick={() => character.openModal('setMedia', { type: 'portrait', aspect: 'aspect-[1/1]' })}
						/>
						<Inline align="start" justify="start" class="z-10">
							<Heading is="h1" as="h3"
								class="max-w-3/4 mt-auto {character.getMedia('banner') ? 'text-white' : ''}"
								heading={character.name}
								headingClass="whitespace-pre-wrap"
							/>
							<Button class="ml-1.5 rounded-full text-accent" size="xs" style="plain" theme="accent" icon="PencilSimple" onclick={() => character.openModal('rename')} />
						</Inline>
						<Inline class="z-10">
							<span class={character.getMedia('banner') ? 'opacity-75 text-white' : ''}>{character.alias}</span>
							<Button class="ml-1.5 rounded-full text-accent " size="xs" style="plain" theme="accent" icon="PencilSimple" onclick={() => character.openModal('alias')} />
						</Inline>
					</ArticleBanner>
				</Section>

				<!-- Details -->

				<Section id="details">
					<Stack class="max-w-[64ch] mx-6 mt-12">
						<Heading is="h3" as="h4" class="mt-9 mb-6">Details</Heading>
						
						<Heading is="h3" as="h6" class="mb-6 text-neutral-soft">Description
							<Button class="ml-1.5 rounded-full text-accent" size="xs" style="plain" theme="accent" icon="PencilSimple" onclick={() => character.openModal('description')} />
						</Heading>
						{#if character.description}
							<Collapsible collapsed={true}
								collapsedClass="line-clamp-3 overflow-hidden">
								{character.description}
							</Collapsible>
						{:else}
							<span class="text-neutral-softest">No description</span>
						{/if}

						<Heading is="h3" as="h6" class="mt-9 mb-6 text-neutral-soft">Appearance
							<Button class="ml-1.5 rounded-full text-accent" size="xs" style="plain" theme="accent" icon="PencilSimple" onclick={() => character.openModal('appearance', { options: $page.props.options.appearance })} />
						</Heading>
						<Flex wrap class="gap-[2px]">
							{#if character.appearance}
								{#each character.appearance?.split(',') as tag}
									<Tag plain class="bg-neutral-softest border border-transparent text-neutral px-2 py-1">{tag}</Tag>
								{/each}
							{:else}
								<span class="text-neutral-softest">No appearance</span>
							{/if}
						</Flex>
	
						<Heading is="h3" as="h6" class="mt-9 mb-6 text-neutral-soft">Personality
							<Button class="ml-1.5 rounded-full text-accent" size="xs" style="plain" theme="accent" icon="PencilSimple" onclick={() => character.openModal('personality', { options: $page.props.options.personality })} />
						</Heading>
						<Flex wrap class="gap-[2px]">
							{#if character.personality}
								{#each character.personality?.split(',') as tag}
									<Tag plain class="bg-neutral-softest border border-transparent text-neutral px-2 py-1">{tag}</Tag>
								{/each}
							{:else}
								<span class="text-neutral-softest">No personality</span>
							{/if}
							<!-- <Button icon="Plus" size="xs" style="plain" theme="accent" class="rounded-full h-7 my-1 w-7" /> -->
						</Flex>
						
					</Stack>
				</Section>

				<Separator class="my-12" />


				<!-- Custom Fields -->
		
				<Section id="custom" class="p-6">
					<Heading is="h3" as="h4" class="mb-6">Custom Fields</Heading>
					<!-- <pre>{JSON.stringify($customFieldForm,null,3)}</pre> -->
					{#if customFields && customFields.length > 0}
						<Stack class="flex flex-col gap-1.5" gap={1.5}>
							{#each customFields as field, i}
								<Flex align="center" gap={3}>
									<span class="font-semibold w-32">{field.label}:</span>
									<Input class="w-64" {...field} bind:value={$customFieldForm.customFields[i].value} />
								</Flex>
							{/each}
							<Button type="submit" class="min-w-32 mt-3 place-self-start"
								text="Save" onclick={submitCustomFields}
								size="md" style="hard" theme="accent"
							/>
						</Stack>
					{:else}
						<span class="text-neutral-softer">There are no custom fields for characters in this project yet.</span>
					{/if}
				</Section>

				<Separator class="my-12" />
		

				<!-- Relationships -->
		
				<Section id="relationships" class="p-6">
					<Heading is="h3" as="h4" class="mb-6">Relationships</Heading>
					<Grid cols={6} gap={3}>
						{#if character.relationships?.items?.length > 0}
							{#each character.relationships.items as rel, i}
								<Entity
									entity={rel}
									subtitle={rel.role}
									href={route('characters.show', { character: rel.slug })}
								/>
							{/each}
							<Button size="lg" style="soft" theme="accent" icon="Plus" iconWeight="light" onclick={() => character.openModal('relationship')} class="aspect-square rounded w-full" />
						{:else}
							<Stack class="col-span-full">
								<p class="italic text-neutral-softer">{character.name} doesn't have any relationships yet.</p>
								<p><button class="text-accent hover:underline" onclick={() => character.openModal('relationship')}>Create one?</button></p>
							</Stack>
						{/if}
					</Grid>
				</Section>

				<Separator class="my-12" />
		
		
				<!-- Factions -->
		
				<Section id="factions" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h4">Factions</Heading>
					</Flex>
					<Grid cols={8} gap={3}>
						{#if character.factions?.items?.length > 0}
							{#each character.factions?.items as fac, i}
								<Entity
									entity={fac}
									subtitle={fac.type}
									href={route('factions.show', { faction: fac.slug })}
								/>
							{/each}
							<Button size="lg" style="soft" theme="accent" icon="Plus" iconWeight="light" onclick={() => character.openModal('relationship')} class="aspect-square rounded w-full" />
						{:else}
							<Stack class="col-span-full">
								<p class="italic text-neutral-softer">{character.name} isn't in any factions yet.</p>
								<p><button class="text-accent hover:underline" onclick={() => character.openModal('faction')}>Add one?</button></p>
							</Stack>
						{/if}
					</Grid>
				</Section>

				<Separator class="my-12" />


				<!-- Location -->
		
				<Section id="location" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h4">Location</Heading>
					</Flex>
					{#if character.mapData?.location}
						<Map.Context class="aspect-video rounded-lg shadow"
							location={character?.location}
							navigable={false}
							onUpload={() => character.openModal('location')}
						/>
					{:else}
						<p class="italic text-neutral-softer">{character.name} hasn't been assigned any locations yet.</p>
						<p><Link onclick={() => character.openModal('location')}>Assign one?</Link></p>
					{/if}
				</Section>

				<Separator class="my-12" />


				<!-- Inventory -->
		
				<Section id="items" class="p-6">
					<Flex align="center" class="mb-6">
						<Heading is="h3" as="h4">Inventory</Heading>
					</Flex>
					<Grid cols={6} gap={0.5} class="rounded overflow-hidden">
						{#each new Array(12) as item, i}
							<Thumbnail aspect="square"
								class="aspect-square bg-neutral-softest"
							/>
						{/each}
						{#each character.inventory as item, i}
							<Entity
								entity={item}
							/>
						{/each}
					</Grid>
				</Section>

				<Separator class="my-12" />
		
		
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