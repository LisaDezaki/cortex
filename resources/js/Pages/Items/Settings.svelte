<script>
	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout	 from '@/Layouts/AuthenticatedLayout.svelte'
	import ItemSettingsForm from '@/Forms/Settings/ItemSettings.svelte'
	import Flex   	  from '@/Components/Core/Flex.svelte'
	import Inline     from '@/Components/Core/Inline.svelte'
	import Stack   	  from '@/Components/Core/Stack.svelte'
	import Button  	  from '@/Components/UI/Button.svelte'
	import Container  from '@/Components/UI/Container.svelte'
	import Heading    from '@/Components/UI/Heading.svelte'
	import Icon			from '@/Components/UI/Icon.svelte'
	import PageHeading from '@/Components/UI/PageHeading.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'
	import Section    from '@/Components/UI/Section.svelte'
	import Separator  from '@/Components/UI/Separator.svelte'
	import ProjectObject 	from '@/services/ProjectObject'

	/**
	 * Active project instance
	 * @type {ProjectObject}
	 */
	const activeProject	= new ProjectObject($page.props.activeProject.data)
	const items    = activeProject?.items
	
	const customFields = $page.props.customFields?.data
	const settings     = $page.props.settings?.items?.data

	let customFieldForm = useForm({
		customFields: customFields
	})

	function submitCustomFields() {
		$customFieldForm.patch(route('customFields.updateOrder', {

		}))

	}

	const customFieldIcons = {
		text:	'TextAa',
		number:	'Hash',
		link:	'Link',
		switch:	'ToggleRight',
		select:	'RowsPlusBottom',
		entity:	'Table',
		upload:	'File'
	}

</script>



<svelte:head>
    <title>Items Settings</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Flex justify="center" gap={12} class="overflow-y-auto px-20">
			<PageMenu class="py-12"
				back={{ text: 'Item List', href: route('items') }}
				items={[
					{ icon: "UserList",		label: "Overview",		href: "#overview"	},
					{ icon: "Coins",		label: "Currencies",	href: "#currencies"	},
					{ icon: "ImagesSquare",	label: "Media",			href: "#media"		},
					{ icon: "Textbox",		label: "Custom Fields",	href: "#custom"		},
				]}
			/>
			<Container size="2xl" class="py-12">

				<PageHeading
					title="Item Settings"
					subtitle="Manage the Item Settings for this project."
					class="mb-12 text-neutral-softest"
				/>

				<Section id="overview" gap={6}>
					<Heading is="h4" as="h5">Overview</Heading>
					<ItemSettingsForm />
				</Section>

				<Separator class="my-12" />

				<Section id="currencies" gap={6}>
					<Heading is="h4" as="h5">Currencies</Heading>
					<!-- <ItemSettingsForm /> -->
				</Section>

				<Separator class="my-12" />

				<Section id="crafting" gap={6}>
					<Heading is="h4" as="h5">Crafting</Heading>
					<!-- <ItemSettingsForm /> -->
				</Section>

				<Separator class="my-12" />

				<Section id="media" gap={6}>
					<Heading is="h4" as="h5">Media</Heading>
					<p class="mb-3">These media settings apply to all characters in this project.</p>
				</Section>

				<Separator class="my-12" />

				<Section id="custom" gap={6}>
					<Heading is="h4" as="h5">Custom Fields</Heading>
					<p class="mb-3">These custom fields will apply to all items in this project. If you want to add custom fields to all projects, visit your <Link href={route('user.settings')}>App Settings</Link> page.</p>
					
					{#if $customFieldForm.customFields?.length > 0}

						<Reorder.List bind:items={$customFieldForm.customFields} class="place-self-start w-96">
							{#snippet children({item,index})}
								<Flex align="center" gap={1.5} class="bg-slate-50 group p-md rounded">
									<Reorder.Handle {index} />
									<span class="w-32 flex-none">{item.label}</span>
									<Inline class="w-40 flex-1 text-sm text-neutral-soft" gap={1.5}>
										<Icon name={customFieldIcons[item.type]} size="sm" />
										<span>{item.type.charAt(0).toUpperCase() + item.type.slice(1)}</span>
										<span class="text-xs ml-auto">
											{#if item.min && item.max}
												({item.min}-{item.max})
											{/if}
											{#if item.options.length > 0}
												({item.options.length} options)
											{/if}
										</span>
									</Inline>
									<Button class="opacity-0 group-hover:opacity-100"
										size="sm" style="plain" theme="accent"
										icon="GearFine" onclick={() => items.openModal('customField', { field: item })}
									/>
								</Flex>
							{/snippet}
						</Reorder.List>
						<Flex justify="between" class="w-96">
							<Button class="place-self-start" style="soft" theme="accent"
								icon="Plus" iconWeight="light" 
								onclick={() => items.openModal('customField', { endpoint: route('customFields.store'), patch: 'post' })}
							/>
							<Button class="place-self-start" style="soft" theme="accent"
								text="Save"
								onclick={submitCustomFields}
							/>
						</Flex>
					{:else}
						<span class="mx-auto text-neutral-softest">There are no custom fields yet.</span>
					{/if}

					<Button class="mt-3 mx-auto rounded-full"
						style="soft" theme="accent"
						icon="Plus" text="Add Custom Field"
						onclick={() => items.openModal('customField', { endpoint: route('customFields.store'), patch: 'post' })}
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