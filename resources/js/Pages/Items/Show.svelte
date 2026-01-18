<script>
	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Box 		 	 from '@/Components/Core/Box.svelte'
	import Flex 		 from '@/Components/Core/Flex.svelte'
	import Grid 		 from '@/Components/Core/Grid.svelte'
	import Inline 		 from '@/Components/Core/Inline.svelte'
	import Map			 from '@/Components/Core/Map'
	import Stack 		 from '@/Components/Core/Stack.svelte'
	import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
	import Badge         from '@/Components/UI/Badge.svelte'
	import Button        from '@/Components/UI/Button.svelte'
	import Collapsible   from '@/Components/UI/Collapsible.svelte'
	import Container  	 from '@/Components/UI/Container.svelte'
	import Heading    	 from '@/Components/UI/Heading.svelte'
	import Icon    	 	 from '@/Components/UI/Icon.svelte'
	import Input    	 from '@/Components/UI/Input'
	import Media     	 from '@/Components/UI/Media.svelte'
	import PageMenu   	 from '@/Components/UI/PageMenu.svelte'
	import Section    	 from '@/Components/UI/Section.svelte'
	import Separator     from '@/Components/UI/Separator.svelte'
	import Tag     		 from '@/Components/UI/Tag.svelte'
	import Thumbnail     from '@/Components/UI/Thumbnail.svelte'
	import ItemObject	 from '@/services/ItemObject';
	import ProjectObject from '@/services/ProjectObject';

	/**
	 * Active item instance
	 * @type {ItemObject}
	 */
	const active  = new ProjectObject($page.props.activeProject?.data)
	const item    = new ItemObject($page.props.item?.data)
	const customFields = $page.props.customFields?.data

	let isConsumable = $derived(item.consumable || false)
	let isCraftable  = $derived(item.craftable  || false)
	let isEquippable = $derived(item.equippable || false)
	let isScrappable = $derived(item.scrappable || false)
	let isWeaponable = $derived(item.weaponable || false)
	let isMeleeable  = $derived(item.weaponable?.melee || false)
	let isThrownable = $derived(item.weaponable?.thrown || false)
	let isRangedable = $derived(item.weaponable?.ranged || false)

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
							class="absolute inset-0 aspect-[21/9] bg-slate-200 rounded-lg overflow-hidden"
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

				<!-- <Flex gap={6} class="px-3">
					<Input.Checkbox
						bind:checked={item.consumable}
						labelText="Consumable"
					/>
					<Input.Checkbox
						bind:checked={item.craftable}
						labelText="Craftable"
					/>
					<Input.Checkbox
						bind:checked={item.equippable}
						labelText="Equippable"
					/>
					<Input.Checkbox
						bind:checked={item.weaponable}
						labelText="Weapon"
					/>
				</Flex> -->

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


						<Stack gap={1.5} class="mt-6">
							
						</Stack>
						
					</Stack>
				</Section>

				<Separator class="my-12" />


				<!-- Crafting & Scrapping -->

				<Section id="crafting">
					<Grid cols={2} gap={6}>
						<Stack class="mx-6 mb-6">
							<Flex align="end" class="mt-9 mb-6">
								<Heading is="h3" as="h4">Craftable</Heading>
								<Input.Switch
									bind:checked={isCraftable}
									class="ml-6 my-0.5"
								/>
							</Flex>
							{#if isCraftable}
								<Heading is="h6" as="p" class="font-semibold mb-3">Materials required for crafting</Heading>
								<Grid cols={3} gap={1.5}>
									{#each new Array(6) as craftItem, i}
										<Stack>
											<Box class="relative">
												<Thumbnail aspect="square"
													class="aspect-square bg-neutral-softest rounded hover:inner-shadow-sm transition-all"
													src={active.items.items.find(it => it.slug === item.craftable.components[i]?.item)?.getMedia('icon')?.url}
												/>
												{#if Object.keys(item.craftable)[i]}
													<Badge class="absolute bottom-1.5 right-1.5 p-1 text-lg" style="hard" theme="neutral"
														text="x{item.craftable.components[i]?.quantity}"
													/>
												{/if}
											</Box>
											{#if item.craftable.components[i]}
												<Inline class="text-sm">{ active.items.items?.find(it => it.slug === item.craftable.components[i]?.item).name }</Inline>
											{/if}
										</Stack>
									{/each}
								</Grid>
							{:else}
								<p class="italic text-neutral-softest">This item is not craftable.</p>
							{/if}
						</Stack>
						<Stack class="mx-6 mb-6">
							<Flex align="end" class="mt-9 mb-6">
								<Heading is="h3" as="h4">Scrappable</Heading>
								<Input.Switch
									bind:checked={isScrappable}
									class="ml-6 my-0.5"
								/>
							</Flex>
							{#if isScrappable}
								<Heading is="h6" as="p" class="font-semibold mb-3">Materials produced from scrapping</Heading>
								<Grid cols={3} gap={1.5}>
									{#each new Array(6) as scrapItem, i}
										<Stack>
											<Box class="relative">
												<Thumbnail aspect="square"
													class="aspect-square bg-neutral-softest rounded hover:inner-shadow-sm transition-all"
													src={active.items.items.find(it => it.slug === Object.keys(item.scrappable || {})?.[i] )?.getMedia('icon')?.url}
												/>
												{#if Object.keys(item.scrappable || {})[i]}
													<Badge class="absolute bottom-1.5 right-1.5 p-1 text-lg" style="hard" theme="neutral"
														text="x{item.scrappable[Object.keys(item.scrappable || {})[i]]}"
													/>
												{/if}
											</Box>
											{#if Object.keys(item.scrappable || {})[i]}
												<Inline class="text-md">{ active.items.items.find(it => it.slug === Object.keys(item.scrappable || {})[i]).name }</Inline>
											{/if}
										</Stack>
									{/each}
								</Grid>
							{:else}
								<p class="italic text-neutral-softest">This item is not scrappable.</p>
							{/if}
						</Stack>
					</Grid>
				</Section>

				<Separator class="my-12" />

				<!-- Consumable -->

				<Section id="consumable">
					<Stack class="mx-6">
						<Flex align="end" class="mt-9 mb-6">
							<Heading is="h3" as="h4">Consumable</Heading>
							<Input.Switch
								bind:checked={isConsumable}
								class="ml-6 my-0.5"
							/>
						</Flex>
						{#if isConsumable}
							<Heading is="h4" as="h6" class="mb-3">Effects</Heading>
							<Grid cols={3} gap={1.5}>
								{#each new Array(3) as effect, i}
									{#if item.consumable}
										<Stack class="aspect-video bg-neutral-softest p-3 rounded" gap={1.5}>
											<Heading is="h5" as="h6" class="mb-2">Effect {i + 1}</Heading>
											<Input.Text placeholder="Effect Name" bind:value={item.consumable.effect} />
											<Input.Number placeholder="Effect Magnitude" bind:value={item.consumable.magnitude} />
											{#if item.consumable.effect === 'deal_damage'}
												<Flex align="center" justify="between">
													<span class="text-sm">Dmg type:</span>
													<Input.Select class="w-32" bind:value={item.consumable.damage_type}
														options={[
															{ label: 'Acid',		value: 'acid'		 },
															{ label: 'Bludgeoning',	value: 'bludgeoning' },
															{ label: 'Cold',		value: 'cold'		 },
															{ label: 'Electric',	value: 'electric'	 },
															{ label: 'Fire',		value: 'fire'		 },
															{ label: 'Force',		value: 'force'		 },
															{ label: 'Healing',		value: 'healing'	 },
															{ label: 'Lightning',	value: 'lightning'	 },
															{ label: 'Necrotic',	value: 'necrotic'	 },
															{ label: 'Piercing',	value: 'piercing'	 },
															{ label: 'Poison',		value: 'poison'		 },
															{ label: 'Psychic',		value: 'psychic'	 },
															{ label: 'Radiant',		value: 'radiant'	 },
															{ label: 'Slashing',	value: 'slashing'	 },
															{ label: 'Thunder',		value: 'thunder'	 }
														]}
													/>
												</Flex>
											{/if}
										</Stack>
									{/if}
								{/each}
							</Grid>
						{:else}
							<p class="italic text-neutral-softest">This item is not consumable.</p>
						{/if}
					</Stack>
				</Section>

				<Separator class="my-12" />

				<!-- Wearable -->

				<Section id="equippable">
					<Stack class="mx-6">
						<Flex align="end" class="mt-9 mb-6">
							<Heading is="h3" as="h4">Equippable</Heading>
							<Input.Switch
								bind:checked={isEquippable}
								class="ml-6 my-0.5"
							/>
						</Flex>
						{#if isEquippable}
							<Heading is="h6" as="p" class="font-semibold mb-3">Equip Slot:</Heading>
							<Inline align="center" gap={1.5}>
								<Input.Select class="w-48"
									bind:value={item.wearable_slot}
									options={[
										{ label: 'Head',	value: 'head'	},
										{ label: 'Earring',	value: 'ears'	},
										{ label: 'Face',	value: 'face'	},
										{ label: 'Neck',	value: 'neck'	},
										{ separator: true },
										{ label: 'Arms',	value: 'arms'	},
										{ label: 'Wrist',	value: 'wrist'	},
										{ label: 'Finger',	value: 'finger'	},
										{ separator: true },
										{ label: 'Torso',	value: 'torso'	},
										{ label: 'Back',	value: 'back'	},
										{ label: 'Waist',	value: 'waist'	},
										{ separator: true },
										{ label: 'Legs',	value: 'legs'	},
										{ label: 'Feet',	value: 'feet'	},
									]}
								/>
								<Button style="soft" theme="accent" icon="Plus" />
							</Inline>
						{:else}
							<p class="italic text-neutral-softest">This item is not equippable.</p>
						{/if}
					</Stack>
				</Section>

				<Separator class="my-12" />

				<!-- Weapon -->

				<Section id="weapon">
					<Stack class="mx-6">
						<Flex align="end" class="mt-9 mb-6">
							<Heading is="h3" as="h4">Weapon</Heading>
							<Input.Switch
								bind:checked={isWeaponable}
								class="ml-6 my-0.5"
							/>
						</Flex>
						{#if item.weaponable}
							<Grid cols={3} gap={3}>
								{#each ['Melee', 'Thrown', 'Ranged'] as attackType}
									<Stack>
										<Flex align="center" justify="between">
											<Heading is="h4" as="h6" class="mb-3">{attackType}</Heading>
											{#if attackType === 'Melee'}
												<Input.Switch size="sm" bind:checked={isMeleeable} />
											{:else if attackType === 'Thrown'}
												<Input.Switch size="sm" bind:checked={isThrownable} />
											{:else if attackType === 'Ranged'}
												<Input.Switch size="sm" bind:checked={isRangedable} />
											{/if}
										</Flex>
										<Stack class="aspect-video bg-neutral-softest p-3 rounded text-sm w-full">
											{#if item.weaponable[attackType.toLowerCase()]}
												<Inline>
													<span class="mr-auto">Hands:</span>
													<span>{item.weaponable?.[attackType.toLowerCase()]?.hands}</span>
												</Inline>
												<Inline>
													<span class="mr-auto">Range:</span>
													<span>{item.weaponable?.[attackType.toLowerCase()]?.range}</span>
												</Inline>
												<Inline>
													<span class="mr-auto">Effect:</span>
													<span>{item.weaponable?.[attackType.toLowerCase()]?.effect}</span>
												</Inline>
												<Inline>
													<span class="mr-auto">Magnitude:</span>
													<span>{item.weaponable?.[attackType.toLowerCase()]?.magnitude}</span>
												</Inline>
												{#if item.weaponable?.[attackType.toLowerCase()]?.damage_type}
													<Inline>
														<span class="mr-auto">Damage type:</span>
														<span>{item.weaponable?.[attackType.toLowerCase()]?.damage_type}</span>
													</Inline>
												{/if}
											{/if}
										</Stack>
									</Stack>
								{/each}
								<!-- <Stack>
									<Flex align="center" justify="between">
										<Heading is="h4" as="h6" class="mb-3">Thrown</Heading>
										<Input.Switch size="sm" />
									</Flex>
									<Thumbnail aspect="square"
										class="aspect-video bg-neutral-softest rounded-none hover:inner-shadow-sm transition-all w-full"
									/>
								</Stack>
								<Stack>
									<Flex align="center" justify="between">
										<Heading is="h4" as="h6" class="mb-3">Ranged</Heading>
										<Input.Switch size="sm" />
									</Flex>
									<Thumbnail aspect="square"
										class="aspect-video bg-neutral-softest rounded-none hover:inner-shadow-sm transition-all w-full"
									/>
								</Stack> -->
							</Grid>
						{:else}
							<p class="italic text-neutral-softest">This item is not weaponable.</p>
						{/if}
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