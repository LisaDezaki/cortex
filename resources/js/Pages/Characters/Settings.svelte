<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout	 from '@/Layouts/AuthenticatedLayout.svelte'
	import CharacterSettingsForm from '@/Forms/Settings/CharacterSettings.svelte'
	import Flex   	  from '@/Components/Core/Flex.svelte'
	import Inline     from '@/Components/Core/Inline.svelte'
	import Stack   	  from '@/Components/Core/Stack.svelte'
	import Button  	  from '@/Components/UI/Button.svelte'
	import Heading    from '@/Components/UI/Heading.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import PageHeading from '@/Components/UI/PageHeading.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'
	import Section    from '@/Components/UI/Section.svelte'
	import Separator  from '@/Components/UI/Separator.svelte'
	import { modalActions } from '@/stores/modalStore'

	const customFields = $page.props.customFields?.data
	const settings     = $page.props.settings?.characters?.data

</script>



<svelte:head>
    <title>Character Settings</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}

		<PageHeader size="7xl" class="px-20 py-2" tabs={[
			{ text: "Character List",	href: route('characters') },
			{ text: "Settings", 		active: true },
		]} />

		<Flex justify="center" gap={12} class="flex-1 overflow-y-auto px-20 py-12 w-full">
			<PageMenu items={[
				{ icon: "UserList",       label: "Overview",      href: "#overview" },
				{ icon: "ImagesSquare",   label: "Media",         href: "#media"    },
				{ icon: "Textbox",        label: "Custom Fields", href: "#custom"   }
			]} />
			<Stack class="max-w-5xl w-full">

				<PageHeading
					title="Character Settings"
					subtitle="Manage the Character Settings for this project."
					class="mb-12 text-neutral-softest"
				/>

				<Section id="overview" gap={6}>
					<Heading is="h4" as="h5">Overview</Heading>
					<CharacterSettingsForm />
				</Section>

				<Separator class="my-12" />

				<Section id="media" gap={6}>
					<Heading is="h4" as="h5">Media</Heading>
					<p class="mb-3">These media settings apply to all characters in this project.</p>
				</Section>

				<Separator class="my-12" />

				<Section id="custom" gap={6}>
					<Heading is="h4" as="h5">Custom Fields</Heading>
					<p class="mb-3">These custom fields will apply to all characters in this project. If you want to add custom fields to all projects, visit your <Link href={route('user.settings')}>App Settings</Link> page.</p>
					
					{#if customFields?.length > 0}
						<Stack align="start">
							<Inline align="center">
								<Inline class="font-style-label w-24">Name</Inline>
								<Inline class="font-style-label w-20">Type</Inline>
								<Inline class="font-style-label w-24">Default</Inline>
								<Inline class="font-style-label w-32">Placeholder</Inline>
								<!-- <Inline class="font-style-label">Field</Inline> -->
							</Inline>
							{#each customFields as field}
								<Inline align="center" class="group my-1">
									<Inline class="shrink-0 text-sm w-24">{field.label}</Inline>
									<Inline class="shrink-0 text-sm w-20 capitalize">{field.type}</Inline>
									<Inline class="shrink-0 text-sm w-24 {field.default ? null : 'text-neutral-softest'}">{field.default || 'None'}</Inline>
									<Inline class="shrink-0 text-sm w-32">{field.placeholder}</Inline>
									<!-- <Input {...field} id={undefined} label={undefined} class="mr-2 w-full" /> -->
									<Button class="opacity-0 group-hover:opacity-100 ml-auto rounded-full"
										size="sm" style="soft" theme="accent"
										icon="PencilSimple"
										onclick={() => modalActions.open('customField', { field })}
									/>
								</Inline>
								<Separator class="opacity-50" />
								<!-- {#if field.options}
									<Flex>
										{#each field.options as option}
											<Inline>{option.label}</Inline>
										{/each}
									</Flex>
								{/if} -->
							{/each}
						</Stack>
					{:else}
						<span class="mx-auto text-neutral-softest">There are no custom fields yet.</span>
					{/if}

					<Button class="mt-3 mx-auto rounded-full"
						style="hard" theme="accent"
						icon="Plus" text="Add Custom Field"
						onclick={() => modalActions.open('customField', { field: { fieldableType: 'character' } })}
					/>
				</Section>
			</Stack>
		</Flex>
	{/snippet}

	{#snippet sidebar()}
		<div class="bg-slate-50 min-w-80 shadow-lg"></div>
	{/snippet}
</AuthenticatedLayout>