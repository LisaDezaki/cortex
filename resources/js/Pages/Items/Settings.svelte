<script>
    import { Link, page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
    import ItemSettingsForm from '@/Forms/Settings/ItemSettings.svelte'
    import Flex from '@/Components/Core/Flex.svelte'
    import Inline from '@/Components/Core/Inline.svelte'
    import Stack from '@/Components/Core/Stack.svelte'
    import Button from '@/Components/UI/Button.svelte'
    import Container from '@/Components/UI/Container.svelte'
    import Heading from '@/Components/UI/Heading.svelte'
    import Icon from '@/Components/UI/Icon.svelte'
    import Input from '@/Components/UI/Input'
    import PageHeading from '@/Components/UI/PageHeading.svelte'
    import PageMenu from '@/Components/UI/PageMenu.svelte'
    import Section from '@/Components/UI/Section.svelte'
    import Separator from '@/Components/UI/Separator.svelte'
    import ProjectObject from '@/services/ProjectObject'

    /**
     * Active project instance
     * @type {ProjectObject}
     */
    const activeProject = new ProjectObject($page.props.activeProject.data)
    const items = activeProject?.items

    const customFields = $page.props.customFields?.data
    const settings = $page.props.settings?.items?.data

    let customFieldForm = useForm({
        customFields: customFields,
    })

    let currencyForm = useForm({
        currency_enabled: settings?.currency_enabled || true,
        base_currency: 'gold',
    })

    let craftingForm = useForm({
        crafting_enabled: settings?.crafting_enabled || true,
        scrapping_enabled: settings?.scrapping_enabled || false,
    })

    let weaponsForm = useForm({
        weapons_enabled: settings?.weapons_enabled || true,
        melee_enabled: settings?.melee_enabled || true,
        throwing_enabled: settings?.throwing_enabled || true,
        ranged_enabled: settings?.ranged_enabled || true,
    })

    function submitCustomFields() {
        $customFieldForm.patch(route('customFields.updateOrder', {}))
    }

    const customFieldIcons = {
        text: 'TextAa',
        number: 'Hash',
        link: 'Link',
        switch: 'ToggleRight',
        select: 'RowsPlusBottom',
        entity: 'Table',
        upload: 'File',
    }
</script>

<svelte:head>
    <title>Items Settings</title>
</svelte:head>

<AuthenticatedLayout>
    {#snippet article()}
        <Flex justify="center" gap={12} class="overflow-y-auto px-20">
            <PageMenu
                class="py-12"
                back={{ text: 'Item List', href: route('items') }}
                items={[
                    { icon: 'UserList', label: 'Overview', href: '#overview' },
                    { icon: 'Hammer', label: 'Crafting', href: '#crafting' },
                    { icon: 'Coins', label: 'Currencies', href: '#currencies' },
                    { icon: 'Sword', label: 'Weapons', href: '#weapons' },
                    { icon: 'ImagesSquare', label: 'Media', href: '#media' },
                    { icon: 'Textbox', label: 'Custom Fields', href: '#custom' },
                ]}
            />
            <Container size="2xl" class="py-12">
                <PageHeading
                    title="Item Settings"
                    subtitle="Manage the Item Settings for this project."
                    class="text-neutral-softest mb-12"
                />

                <Section id="overview" gap={6}>
                    <Heading is="h4" as="h5">Overview</Heading>
                    <ItemSettingsForm />
                </Section>

                <Separator class="my-12" />

                <Section id="crafting" gap={6}>
                    <Heading is="h4" as="h5">Crafting</Heading>
                    <Input.Switch
                        bind:checked={$craftingForm.crafting_enabled}
                        label="Enable Crafting System"
                        helpText="Allow users to craft items using resources."
                    />
                    {#if $craftingForm.crafting_enabled}
                        <Input.Switch
                            bind:checked={$craftingForm.scrapping_enabled}
                            label="Enable Scrapping System"
                            helpText="Allow users to scrap items for resources."
                        />
                    {/if}
                </Section>

                <Separator class="my-12" />

                <Section id="currencies" gap={6}>
                    <Inline gap={3}>
                        <Heading is="h4" as="h5">Currencies</Heading>
                        <Input.Switch bind:checked={$currencyForm.currency_enabled} />
                    </Inline>
                    {#if $currencyForm.currency_enabled}
                        <Inline gap={3}>
                            <span>Base currency: </span>
                            <Input.Select
                                bind:value={$currencyForm.base_currency}
                                icon="Coins"
                                options={[
                                    'Caps',
                                    'Cred',
                                    'Credits',
                                    'Coins',
                                    'Dollars',
                                    'Energy',
                                    'Gold',
                                    'Reputation',
                                    'Septims',
                                    'Tokens',
                                    'Units',
                                ].map((o) => ({ label: o, value: o.toLowerCase() }))}
                            />
                        </Inline>
                    {/if}
                </Section>
                <!-- <Input.Switch
                    bind:checked={$currencyForm.currency_enabled}
                    label="Enable Currency System"
                    helpText="Items can be given a currency value for buying and selling."
                /> -->

                <Separator class="my-12" />

                <Section id="weapons" gap={6}>
                    <Inline gap={3}>
                        <Heading is="h4" as="h5">Weapons</Heading>
                        <Input.Switch bind:checked={$weaponsForm.weapons_enabled} />
                    </Inline>
                    <!-- <Input.Switch
                        bind:checked={$weaponsForm.weapons_enabled}
                        label="Enable Weapons System"
                        helpText="Allow users to use items as weapons."
                    /> -->
                    {#if $weaponsForm.weapons_enabled}
                        <Inline class="font-semibold">
                            <Heading is="h6" as="p">Attack Types:</Heading>
                        </Inline>
                        <Flex gap={6}>
                            <Input.Checkbox
                                bind:checked={$weaponsForm.melee_enabled}
                                labelText="Melee"
                                helpText="Allow weapons to be used up close and personal."
                            />
                            <Input.Checkbox
                                bind:checked={$weaponsForm.throwing_enabled}
                                labelText="Throwing"
                                helpText="Allow weapons to be thrown from a distance."
                            />
                            <Input.Checkbox
                                bind:checked={$weaponsForm.throwing_enabled}
                                labelText="Ranged"
                                helpText="Allow weapons to be used from a distance."
                            />
                        </Flex>
                    {:else}
                        <Flex>Enable this to allow Weapon class items</Flex>
                    {/if}
                </Section>

                <Separator class="my-12" />

                <Section id="media" gap={6}>
                    <Heading is="h4" as="h5">Media</Heading>
                    <p class="mb-3">These media settings apply to all characters in this project.</p>
                </Section>

                <Separator class="my-12" />

                <Section id="custom" gap={6}>
                    <Heading is="h4" as="h5">Custom Fields</Heading>
                    <p class="mb-3">
                        These custom fields will apply to all items in this project. If you want to add custom fields to
                        all projects, visit your <Link href={route('user.settings')}>App Settings</Link> page.
                    </p>

                    {#if $customFieldForm.customFields?.length > 0}
                        <Reorder.List bind:items={$customFieldForm.customFields} class="w-96 place-self-start">
                            {#snippet children({ item, index })}
                                <Flex align="center" gap={1.5} class="p-md group rounded bg-slate-50">
                                    <Reorder.Handle {index} />
                                    <span class="w-32 flex-none">{item.label}</span>
                                    <Inline class="text-neutral-soft w-40 flex-1 text-sm" gap={1.5}>
                                        <Icon name={customFieldIcons[item.type]} size="sm" />
                                        <span>{item.type.charAt(0).toUpperCase() + item.type.slice(1)}</span>
                                        <span class="ml-auto text-xs">
                                            {#if item.min && item.max}
                                                ({item.min}-{item.max})
                                            {/if}
                                            {#if item.options.length > 0}
                                                ({item.options.length} options)
                                            {/if}
                                        </span>
                                    </Inline>
                                    <Button
                                        class="opacity-0 group-hover:opacity-100"
                                        size="sm"
                                        style="plain"
                                        theme="accent"
                                        icon="GearFine"
                                        onclick={() => items.openModal('customField', { field: item })}
                                    />
                                </Flex>
                            {/snippet}
                        </Reorder.List>
                        <Flex justify="between" class="w-96">
                            <Button
                                class="place-self-start"
                                style="soft"
                                theme="accent"
                                icon="Plus"
                                iconWeight="light"
                                onclick={() =>
                                    items.openModal('customField', {
                                        endpoint: route('customFields.store'),
                                        patch: 'post',
                                    })}
                            />
                            <Button
                                class="place-self-start"
                                style="soft"
                                theme="accent"
                                text="Save"
                                onclick={submitCustomFields}
                            />
                        </Flex>
                    {:else}
                        <span class="text-neutral-softest mx-auto">There are no custom fields yet.</span>
                    {/if}

                    <Button
                        class="mx-auto mt-3 rounded-full"
                        style="soft"
                        theme="accent"
                        icon="Plus"
                        text="Add Custom Field"
                        onclick={() =>
                            items.openModal('customField', { endpoint: route('customFields.store'), patch: 'post' })}
                    />
                </Section>

                <Separator class="my-12" />
            </Container>
        </Flex>
    {/snippet}

    <!-- {#snippet sidebar()}
		<div class="bg-slate-50 min-w-80 shadow-lg"></div>
	{/snippet} -->
</AuthenticatedLayout>
