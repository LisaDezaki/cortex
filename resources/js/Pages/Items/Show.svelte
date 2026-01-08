<script>
	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Flex 		 from '@/Components/Core/Flex.svelte'
	import Grid 		 from '@/Components/Core/Grid.svelte'
	import Inline 		 from '@/Components/Core/Inline.svelte'
	import Map			 from '@/Components/Core/Map'
	import Stack 		 from '@/Components/Core/Stack.svelte'
	import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
	import Button        from '@/Components/UI/Button.svelte'
	import Collapsible   from '@/Components/UI/Collapsible.svelte'
	import Container  	 from '@/Components/UI/Container.svelte'
	import Heading    	 from '@/Components/UI/Heading.svelte'
	import Input    	 from '@/Components/UI/Input'
	import Media     	 from '@/Components/UI/Media.svelte'
	import PageMenu   	 from '@/Components/UI/PageMenu.svelte'
	import Section    	 from '@/Components/UI/Section.svelte'
	import Separator     from '@/Components/UI/Separator.svelte'
	import Tag     		 from '@/Components/UI/Tag.svelte'
	import Thumbnail     from '@/Components/UI/Thumbnail.svelte'
	import ItemObject from '@/services/ItemObject';

	/**
	 * Active item instance
	 * @type {ItemObject}
	 */
	const item    = new ItemObject($page.props.item?.data)
	const customFields = $page.props.customFields?.data

	let customFieldForm = useForm({
		customFields: customFields?.map((field) => ({
			id: field.id,
			value: character.customFieldValues?.find(cfv => cfv.fieldId === field.id)?.value || null
		}))
	})

	function submitCustomFields() {
		$customFieldForm.patch(character.routes.update, {})
	}

</script>



<svelte:head>
    <title>{item.name}</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Flex justify="center" gap={12} class="overflow-y-auto px-20 py-12">
			<PageMenu
				back={{ text: 'Item List', href: route('items') }}
				items={[
					{ icon: "Info",         	label: "Details",       href: "#details"       },
					{ icon: "Textbox",          label: "Custom Fields", href: "#custom"        },
					{ icon: "Backpack",         label: "Contents",      href: "#items"         },
					{ icon: "MapPinSimpleArea", label: "Location",      href: "#location"      },
					{ icon: "ImagesSquare",     label: "Gallery",       href: "#gallery"       },
					{ icon: "Trash", 			label: "Delete", 		onclick: () => item.openModal('delete'), theme: "danger" }
				]}
			/>
			<Container size="3xl">

				<!-- Header -->
			
				<Section id="header">
					<ArticleBanner>
						<Media
							class="absolute inset-0 aspect-[3/1] bg-slate-200 rounded-lg overflow-hidden"
							media={item.getMedia('banner')}
							onclick={() => item.openModal('setMedia', { type: 'banner', aspect: 'aspect-[7/3]' })}
						/>
						<Media
							class="absolute aspect-square bg-slate-200/50 backdrop-blur hover:backdrop-blur-lg border-2 border-slate-100 right-12 -bottom-16 rounded-lg overflow-hidden w-48"
							media={item.getMedia('portrait')}
							onclick={() => item.openModal('setMedia', { type: 'portrait', aspect: 'aspect-[1/1]' })}
						/>
						<Inline align="start" justify="start" class="z-10">
							<Heading is="h1" as="h3"
								class="max-w-3/4 mt-auto {item.getMedia('banner') ? 'text-white' : ''}"
								heading={item.name}
								headingClass="whitespace-pre-wrap"
							/>
							<Button class="ml-1.5 rounded-full text-accent" size="xs" style="plain" theme="accent" icon="PencilSimple" onclick={() => item.openModal('rename')} />
						</Inline>
						<Inline class="z-10">
							<span class={item.getMedia('banner') ? 'opacity-75 text-white' : ''}>{item.type}</span>
							<Button class="ml-1.5 rounded-full text-accent" size="xs" style="plain" theme="accent" icon="PencilSimple" onclick={() => item.openModal('type')} />
						</Inline>
					</ArticleBanner>
				</Section>

				<!-- Details -->

				<Section id="details">
					<Stack class="max-w-[64ch] mx-6 mt-12">
						<Heading is="h3" as="h4" class="mt-9 mb-6">Details</Heading>
						
						<Heading is="h3" as="h6" class="mb-6 text-neutral-soft">Description
							<Button class="ml-1.5 rounded-full text-accent" size="xs" style="plain" theme="accent" icon="PencilSimple" onclick={() => item.openModal('description')} />
						</Heading>
						{#if item.description}
							<Collapsible collapsed={true}
								collapsedClass="line-clamp-3 overflow-hidden">
								{item.description}
							</Collapsible>
						{:else}
							<p class="italic text-neutral-softest">No description</p>
						{/if}

						<!-- <Heading is="h3" as="h6" class="mt-9 mb-6">Appearance</Heading>
						<Flex wrap class="gap-[2px]">
							{#each character.appearance?.split(',') as tag}
								<Tag plain class="bg-neutral-softest border border-transparent text-neutral px-2 py-1">{tag}</Tag>
							{/each}
							<Button icon="Plus" size="xs" style="plain" theme="accent" class="rounded-full h-7 my-1 w-7" />
						</Flex> -->
	
						<!-- <Heading is="h3" as="h6" class="mt-9 mb-6">Personality</Heading>
						<Flex wrap class="gap-[2px]">
							{#each character.personality?.split(',') as tag}
								<Tag plain class="bg-neutral-softest border border-transparent text-neutral px-2 py-1">{tag}</Tag>
							{/each}
							<Button icon="Plus" size="xs" style="plain" theme="accent" class="rounded-full h-7 my-1 w-7" />
						</Flex> -->
						
						<!-- <Input.Switch
							label="Unique"
							checked={true}
						/> -->

						<Stack gap={1.5} class="mt-6">
							<Flex align="center" gap={3}>
								<span class="font-semibold w-32">Cost:</span>
								<Input.Number size="sm" class="w-32" value={item.cost} />
							</Flex>
	
							<Flex align="center" gap={3}>
								<span class="font-semibold w-32">Weight:</span>
								<Input.Number size="sm" class="w-32" value={item.weight} />
							</Flex>
	
							<Flex align="center" gap={3}>
								<span class="font-semibold w-32">Unique:</span>
								<Input.Switch checked={item.unique} />
							</Flex>
						</Stack>
						
					</Stack>
				</Section>

				<Separator class="my-12" />


				<!-- Custom Fields -->
		
				<Section id="custom" class="p-6">
					<Heading is="h3" as="h4" class="mb-6">Custom Fields</Heading>
					{#if customFields && customFields.length > 0}
						<Stack class="flex flex-col gap-1.5" gap={1.5}>
							{#each customFields as field, i}
								<Flex align="center" gap={3}>
									<span class="font-semibold w-32">{field.label}:</span>
									<!-- <span class="line-clamp-1 {item.customFieldValues.find(cfv => cfv.name === field.name) ? '' : 'text-neutral-softest italic'}">{item.customFieldValues.find(cfv => cfv.name === field.name)?.displayValue || "None"}</span> -->
									<Input class="w-64" {...field} bind:value={$customFieldForm.customFields[i].value} />
								</Flex>
							{/each}
							<Button type="submit" class="min-w-32 mt-3 place-self-start"
								text="Save" onclick={submitCustomFields}
								size="md" style="hard" theme="accent"
							/>
						</Stack>
						<!-- <Flex class="pt-3">
							<Button size="md" style="soft" theme="accent" icon="Plus" iconSize="sm" iconWeight="regular" label="New custom field" onclick={() => {}} />
						</Flex> -->
					{:else}
						<p class="italic text-neutral-softest">There are no custom fields for Items yet.</p>
					{/if}
				</Section>

				<Separator class="my-12" />
		

				<!-- Recipe -->
		
				<!-- <Section id="items" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h4" class="text-neutral-softest">Inventory</Heading>
					</Flex>
					<Grid cols={6} gap={1} class="max-w-[64ch]">
						{#each new Array(12) as item, i}
							<Thumbnail aspect="square"
								class="aspect-square bg-neutral-softest"
							/>
						{/each}
						{#each item.inventory as item, i}
							<Card aspect="square"
								icon="User"
								title={item.name}
								subtitle={item.category}
							/>
						{/each}
					</Grid>
				</Section>

				<Separator class="mx-6 my-6 w-[64ch]" /> -->


				<!-- Location -->
		
				<!-- <Section id="location" class="p-6">
					<Flex align="center" class="mb-6 max-w-[32ch]">
						<Heading is="h3" as="h4" class="text-neutral-softest">Location</Heading>
					</Flex>
					{#if item.mapData?.location}
						<Map.Context class="aspect-video rounded-lg shadow w-[64ch]"
							location={item?.location}
							navigable={false}
							onUpload={() => item.openModal('location')}
						/>
					{:else}
						<p class="font-style-placeholder">{item.name} hasn't been assigned a location yet.</p>
						<p><Link onclick={() => item.openModal('location')}>Assign one?</Link></p>
					{/if}
				</Section>

				<Separator class="mx-6 my-6 w-[64ch]" /> -->
		
		
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