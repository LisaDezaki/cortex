<script>
    import { Link, page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
    import Box from '@/Components/Core/Box.svelte'
    import Flex from '@/Components/Core/Flex.svelte'
    import Grid from '@/Components/Core/Grid.svelte'
    import Inline from '@/Components/Core/Inline.svelte'
    import Map from '@/Components/Core/Map'
    import Stack from '@/Components/Core/Stack.svelte'
    import ArticleBanner from '@/Components/UI/ArticleBanner.svelte'
    import Badge from '@/Components/UI/Badge.svelte'
    import Button from '@/Components/UI/Button.svelte'
    import Collapsible from '@/Components/UI/Collapsible.svelte'
    import Container from '@/Components/UI/Container.svelte'
    import Heading from '@/Components/UI/Heading.svelte'
    import Icon from '@/Components/UI/Icon.svelte'
    import Input from '@/Components/UI/Input'
    import Media from '@/Components/UI/Media.svelte'
    import PageMenu from '@/Components/UI/PageMenu.svelte'
    import Section from '@/Components/UI/Section.svelte'
    import Separator from '@/Components/UI/Separator.svelte'
    import Tag from '@/Components/UI/Tag.svelte'
    import Thumbnail from '@/Components/UI/Thumbnail.svelte'
    import ItemObject from '@/services/ItemObject'
    import ProjectObject from '@/services/ProjectObject'

    /**
     * Active item instance
     * @type {ItemObject}
     */
    const active = new ProjectObject($page.props.activeProject?.data)
    const item = new ItemObject($page.props.item?.data)
    const customFields = $page.props.customFields?.data

    let isConsumable = $derived(item.consumable || false)
    let isCraftable = $derived(item.craftable || false)
    let isEquippable = $derived(item.equippable || false)
    let isScrappable = $derived(item.scrappable || false)
    let isWeaponable = $derived(item.weaponable || false)
    let isMeleeable = $derived(item.weaponable?.melee || false)
    let isThrownable = $derived(item.weaponable?.thrown || false)
    let isRangedable = $derived(item.weaponable?.ranged || false)

	let equipForm = useForm({
		isEquippable: item.equippable || false,
		slot: item.equippable?.slot || null
	})

    let customFieldForm = useForm({
        customFields: customFields?.map((field) => ({
            id: field.id,
            value: character.customFieldValues?.find((cfv) => cfv.fieldId === field.id)?.value || null,
        })),
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
                    { icon: 'Info', label: 'Details', href: '#details' },
                    { icon: 'Textbox', label: 'Custom Fields', href: '#custom' },
                    { icon: 'Backpack', label: 'Contents', href: '#items' },
                    { icon: 'MapPinSimpleArea', label: 'Location', href: '#location' },
                    { icon: 'ImagesSquare', label: 'Gallery', href: '#gallery' },
                    { icon: 'Trash', label: 'Delete', onclick: () => item.openModal('delete'), theme: 'danger' },
                ]}
            />
            <Container size="5xl">

                <!-- Header -->

                <Section id="header">
                    <ArticleBanner>
                        <Media
                            class="absolute inset-0 aspect-[21/9] overflow-hidden rounded-lg bg-slate-200"
                            media={item.getMedia('banner')}
                            onclick={() => item.openModal('setMedia', { type: 'banner', aspect: 'aspect-[7/3]' })}
                        />
                        <Media
                            class="absolute -bottom-16 right-12 aspect-square w-48 overflow-hidden rounded-lg border-2 border-slate-100 bg-slate-200/50 backdrop-blur hover:backdrop-blur-lg"
                            media={item.getMedia('main')}
                            onclick={() => item.openModal('setMedia', { type: 'main', aspect: 'aspect-[1/1]' })}
                        />
                        <Inline align="start" justify="start" class="z-10">
                            <Heading
                                is="h1"
                                as="h3"
                                class="max-w-3/4 mt-auto {item.getMedia('banner') ? 'text-white' : ''}"
                                heading={item.name}
                                headingClass="whitespace-pre-wrap"
                            />
                            <Button
                                class="text-accent ml-1.5 rounded-full"
                                size="xs"
                                style="plain"
                                theme="accent"
                                icon="PencilSimple"
                                onclick={() => item.openModal('rename')}
                            />
                        </Inline>
                        <Inline class="z-10">
                            <span class={item.getMedia('banner') ? 'text-white opacity-75' : ''}>{item.type}</span>
                            <Button
                                class="text-accent ml-1.5 rounded-full"
                                size="xs"
                                style="plain"
                                theme="accent"
                                icon="PencilSimple"
                                onclick={() => item.openModal('type')}
                            />
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
                    <Stack class="mx-6 mt-12 max-w-[64ch]">
                        <Heading is="h3" as="h4" class="mb-6">Details</Heading>

                        <Heading is="h3" as="h6" class="text-neutral-soft mb-6"
                            >Description
                            <Button
                                class="text-accent ml-1.5 rounded-full"
                                size="xs"
                                style="plain"
                                theme="accent"
                                icon="PencilSimple"
                                onclick={() => item.openModal('description')}
                            />
                        </Heading>
                        {#if item.description}
                            <Collapsible collapsed={true} collapsedClass="line-clamp-3 overflow-hidden">
                                {item.description}
                            </Collapsible>
                        {:else}
                            <p class="text-neutral-softest italic">No description</p>
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
                                <span class="w-32 font-semibold">Cost:</span>
                                <Input.Number size="sm" class="w-32" value={item.cost} />
                            </Flex>

                            <Flex align="center" gap={3}>
                                <span class="w-32 font-semibold">Weight:</span>
                                <Input.Number size="sm" class="w-32" value={item.weight} />
                            </Flex>

                            <Flex align="center" gap={3}>
                                <span class="w-32 font-semibold">Unique:</span>
                                <Input.Switch checked={item.unique} />
                            </Flex>
                        </Stack>

                        <Stack gap={1.5} class="mt-6"></Stack>
                    </Stack>
                </Section>

                <Separator class="my-12" />

                <!-- Crafting & Scrapping -->

                <Section id="crafting">
                    <Grid cols={2} gap={6}>
                        <Stack class="mx-6 mb-6">
                            <Flex align="end" class="mb-6">
                                <Heading is="h3" as="h4">Craftable</Heading>
                                <Input.Switch bind:checked={isCraftable} class="my-0.5 ml-6" />
                            </Flex>
                            {#if isCraftable}
                                <Heading is="h6" as="p" class="mb-3 font-semibold">Materials required:</Heading>
                                <Grid cols={3} gap={1.5}>
                                    {#each new Array(6) as _, i}
                                        {@const component = item.craftable?.components?.[i]}
										{@const itemObject = active.items.items.find(it => it.slug === component?.item)}
                                        <Stack
                                            align="center"
                                            justify="center"
                                            class="aspect-square bg-neutral-softest relative p-1.5 rounded w-full"
                                        >
                                            {#if component}
                                                <Stack align="center" class="w-full">
													{#if itemObject?.image?.url}
														<Thumbnail src={itemObject?.image?.url} class="mix-blend-darken" />
													{:else}
														<Flex class="aspect-square w-full">
															<Icon name="Package" />
														</Flex>
													{/if}
                                                    <Inline class="text-sm">
                                                        <span>{component.quantity}x</span>
                                                        <span
                                                            >{active.items.items.find(
                                                                (it) => it.slug === component.item,
                                                            )?.name || component.item}</span
                                                        >
                                                    </Inline>
                                                </Stack>
                                            {:else}
                                                <Flex class="aspect-square w-full">
													<Icon name="Package" class="text-neutral-softest opacity-50" />
												</Flex>
												<Inline class="text-sm">&nbsp;</Inline>
                                            {/if}
                                        </Stack>
                                    {/each}
                                </Grid>
                                <Heading is="h6" as="p" class="mb-3 mt-6 font-semibold">Stations required:</Heading>
                                {#each item.craftable.requirements as req}
                                    <Inline class="bg-neutral-softest rounded p-3 text-sm" gap={3}>
                                        <Icon name="LockKey" />
                                        <span>{req}</span>
                                    </Inline>
                                {/each}
                            {:else}
                                <p class="text-neutral-softest italic">Enable this to make this item craftable.</p>
                            {/if}
                        </Stack>
                        <Stack class="mx-6 mb-6">
                            <Flex align="end" class="mb-6">
                                <Heading is="h3" as="h4">Scrappable</Heading>
                                <Input.Switch bind:checked={isScrappable} class="my-0.5 ml-6" />
                            </Flex>
                            {#if isScrappable}
                                <Heading is="h6" as="p" class="mb-3 font-semibold">Materials produced:</Heading>
                                <Grid cols={3} gap={1.5}>
                                    {#each new Array(6) as _, i}
                                        {@const component = item.scrappable?.components?.[i]}
										{@const itemObject = active.items.items.find(it => it.slug === component?.item)}
                                        <Stack
                                            align="center"
                                            justify="center"
                                            class="aspect-square bg-neutral-softest relative p-1.5 rounded w-full"
                                        >
                                            {#if component}
                                                <Stack align="center" justify="center">
													{#if itemObject.image?.url}
														<Thumbnail src={itemObject.image?.url} class="mix-blend-darken" />
													{:else}
														<Icon name="Package" />
													{/if}
                                                    <Inline class="text-sm">
                                                        <span>{component.quantity}x</span>
                                                        <span
                                                            >{active.items.items.find(
                                                                (it) => it.slug === component.item,
                                                            ).name || component.item}</span
                                                        >
                                                    </Inline>
                                                </Stack>
                                            {:else}
												<Flex class="aspect-square w-full">
													<Icon name="Package" class="text-neutral-softest opacity-50" />
												</Flex>
												<Inline class="text-sm">&nbsp;</Inline>
                                            {/if}
                                        </Stack>
                                    {/each}
                                </Grid>
                            {:else}
                                <p class="text-neutral-softest italic">Enable this to make this item scrappable.</p>
                            {/if}
                        </Stack>
                    </Grid>
                </Section>

                <Separator class="my-12" />

                <!-- Consumable -->

                <Section id="consumable">
                    <Stack class="mx-6">
                        <Flex align="end" class="mb-6">
                            <Heading is="h3" as="h4">Consumable</Heading>
                            <Input.Switch bind:checked={isConsumable} class="my-0.5 ml-6" />
                        </Flex>
                        {#if isConsumable}
                            <Heading is="h6" as="p" class="mb-3 font-semibold">Effects:</Heading>
                            <Grid cols={3} gap={1.5}>
								{#each item.consumable.effects as effect}
									 <Stack class="bg-neutral-softest aspect-video rounded p-3">
										<Flex align="baseline" justify="between" class="font-semibold mb-2">
											<Heading is="h5" as="p" class="uppercase">{effect.effect}</Heading>
											<span>{effect.magnitude}</span>
										</Flex>
										<Inline class="baseline border-t py-0.5" gap={3}>
											<span class="text-sm w-28">Target:</span>
											<Inline gap={1}>
												<Icon name="Target" size="sm" class="text-neutral-soft" />
												<span>{effect.target}</span>
											</Inline>
										</Inline>
										<Inline class="baseline border-t py-0.5" gap={3}>
											<span class="text-sm w-28">Damage Type:</span>
											<Inline gap={1}>
												<Icon name="Circle" size="sm" class="text-neutral-soft" />
												<span>{effect.damage_type}</span>
											</Inline>
										</Inline>
										<Inline class="baseline border-t py-0.5" gap={3}>
											<span class="text-sm w-28">Duration:</span>
											<Inline gap={1}>
												<Icon name="Timer" size="sm" class="text-neutral-soft" />
												<span>{effect.duration}</span>
											</Inline>
										</Inline>
									</Stack>
								{/each}


                                <!-- {#each new Array(3) as _, i}
                                    {#if item.consumable}
                                        <Stack class="bg-neutral-softest aspect-video rounded p-3" gap={1.5}>
                                            <Heading is="h5" as="h6" class="mb-2">Effect {i + 1}</Heading>
                                            <Input.Text placeholder="Effect Name" bind:value={item.consumable.effect} />
                                            <Input.Number
                                                placeholder="Effect Magnitude"
                                                bind:value={item.consumable.magnitude}
                                            />
                                            {#if item.consumable.effect === 'deal_damage'}
                                                <Flex align="center" justify="between">
                                                    <span class="text-sm">Dmg type:</span>
                                                    <Input.Select
                                                        class="w-32"
                                                        bind:value={item.consumable.damage_type}
                                                        options={[
                                                            { label: 'Acid', value: 'acid' },
                                                            { label: 'Bludgeoning', value: 'bludgeoning' },
                                                            { label: 'Cold', value: 'cold' },
                                                            { label: 'Electric', value: 'electric' },
                                                            { label: 'Fire', value: 'fire' },
                                                            { label: 'Force', value: 'force' },
                                                            { label: 'Healing', value: 'healing' },
                                                            { label: 'Lightning', value: 'lightning' },
                                                            { label: 'Necrotic', value: 'necrotic' },
                                                            { label: 'Piercing', value: 'piercing' },
                                                            { label: 'Poison', value: 'poison' },
                                                            { label: 'Psychic', value: 'psychic' },
                                                            { label: 'Radiant', value: 'radiant' },
                                                            { label: 'Slashing', value: 'slashing' },
                                                            { label: 'Thunder', value: 'thunder' },
                                                        ]}
                                                    />
                                                </Flex>
                                            {/if}
                                        </Stack>
                                    {/if}
                                {/each} -->
                            </Grid>
                        {:else}
                            <p class="text-neutral-softest italic">Enable to make this item consumable.</p>
                        {/if}
                    </Stack>
                </Section>

                <Separator class="my-12" />

                <!-- Equipabble -->

                <Section id="equippable">
                    <Stack class="mx-6">
                        <Flex align="end" class="mb-6">
                            <Heading is="h3" as="h4">Equippable</Heading>
                            <Input.Switch bind:checked={isEquippable} class="my-0.5 ml-6" />
                        </Flex>
                        {#if isEquippable}
                            <Heading is="h6" as="p" class="mb-3 font-semibold">Equip Slot:</Heading>
                            <Inline align="center" gap={1.5}>
                                <Input.Select
                                    class="w-48"
                                    bind:value={$equipForm.slot}
                                    options={[
										{ label: 'None',	value: ''	    },
                                        { label: 'Head',	value: 'head'   },
                                        { label: 'Earring', value: 'ears'   },
                                        { label: 'Face',	value: 'face'   },
                                        { label: 'Neck',	value: 'neck'   },
                                        { separator: true },
                                        { label: 'Arms',	value: 'arms'   },
                                        { label: 'Wrist',	value: 'wrist'  },
                                        { label: 'Finger',	value: 'finger' },
                                        { separator: true },
                                        { label: 'Torso',	value: 'torso'  },
                                        { label: 'Back',	value: 'back'   },
                                        { label: 'Waist',	value: 'waist'  },
                                        { separator: true },
                                        { label: 'Legs',	value: 'legs'   },
                                        { label: 'Feet',	value: 'feet'   },
                                    ]}
                                />
                                <Button style="soft" theme="accent" icon="Plus" />
                            </Inline>
                        {:else}
                            <p class="text-neutral-softest italic">Enable to make this item equippable.</p>
                        {/if}
                    </Stack>
                </Section>

                <Separator class="my-12" />

                <!-- Weapon -->

                <Section id="weapon">
                    <Stack class="mx-6">
                        <Flex align="end" class="mb-6">
                            <Heading is="h3" as="h4">Weapon</Heading>
                            <Input.Switch bind:checked={isWeaponable} class="my-0.5 ml-6" />
                        </Flex>
                        {#if isWeaponable}
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
                                        <Stack class="bg-neutral-softest aspect-video w-full rounded p-3 text-sm">
                                            {#if item.weaponable?.[attackType.toLowerCase()]}
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
                                                    <span>{item.weaponable?.[attackType.toLowerCase()]?.magnitude}</span
                                                    >
                                                </Inline>
                                                {#if item.weaponable?.[attackType.toLowerCase()]?.damage_type}
                                                    <Inline>
                                                        <span class="mr-auto">Damage type:</span>
                                                        <span
                                                            >{item.weaponable?.[attackType.toLowerCase()]
                                                                ?.damage_type}</span
                                                        >
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
                            <p class="text-neutral-softest italic">Enable to make this item useable as a weapon.</p>
                        {/if}
                    </Stack>
                </Section>

                <Separator class="my-12" />

                <!-- Custom Fields -->

                <Section id="custom">
                    <Stack class="mx-6">
                        <Heading is="h3" as="h4" class="mb-6">Custom Fields</Heading>
                        {#if customFields && customFields.length > 0}
                            <Stack class="flex flex-col gap-1.5" gap={1.5}>
                                {#each customFields as field, i}
                                    <Flex align="center" gap={3}>
                                        <span class="w-32 font-semibold">{field.label}:</span>
                                        <!-- <span class="line-clamp-1 {item.customFieldValues.find(cfv => cfv.name === field.name) ? '' : 'text-neutral-softest italic'}">{item.customFieldValues.find(cfv => cfv.name === field.name)?.displayValue || "None"}</span> -->
                                        <Input
                                            class="w-64"
                                            {...field}
                                            bind:value={$customFieldForm.customFields[i].value}
                                        />
                                    </Flex>
                                {/each}
                                <Button
                                    type="submit"
                                    class="mt-3 min-w-32 place-self-start"
                                    text="Save"
                                    onclick={submitCustomFields}
                                    size="md"
                                    style="hard"
                                    theme="accent"
                                />
                            </Stack>
                            <!-- <Flex class="pt-3">
    							<Button size="md" style="soft" theme="accent" icon="Plus" iconSize="sm" iconWeight="regular" label="New custom field" onclick={() => {}} />
    						</Flex> -->
                        {:else}
                            <p class="text-neutral-softest italic">There are no custom fields for Items yet.</p>
                        {/if}
                    </Stack>
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
                            <Thumbnail
                                aspect="square"
                                class="bg-neutral-softest hover:inner-shadow-sm aspect-square rounded-none transition-all"
                            />
                        {/each}
                    </Grid>
                </Section>

                <Separator class="my-12" />
            </Container>
        </Flex>
    {/snippet}
</AuthenticatedLayout>
