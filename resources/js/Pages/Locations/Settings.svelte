<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	import LocationSettingsForm from '@/Forms/Settings/LocationSettings.svelte'
	import Flex   	  from '@/Components/Core/Flex.svelte'
	import Inline     from '@/Components/Core/Inline.svelte'
	import Stack   	  from '@/Components/Core/Stack.svelte'
	import Button  	  from '@/Components/UI/Button.svelte'
	import Heading    from '@/Components/UI/Heading.svelte'
	import Input      from '@/Components/UI/Input'
	import PageHeading from '@/Components/UI/PageHeading.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'
	import Section    from '@/Components/UI/Section.svelte'
	import Separator  from '@/Components/UI/Separator.svelte'
	import { modalActions } from '@/stores/modalStore'

	const customFields = $page.props.customFields?.data
	const settings     = $page.props.settings?.locations?.data

</script>



<svelte:head>
    <title>Location Settings</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Flex justify="center" gap={12} class="flex-1 overflow-y-auto px-20 py-12 w-full">
			<PageMenu
				back={{ text: 'Location List', href: route('locations') }}
				items={[
					{ icon: "UserList",       label: "Overview",      href: "#overview"	},
					{ icon: "ImagesSquare",   label: "Media",         href: "#media"	},
					{ icon: "Textbox",        label: "Custom Fields", href: "#custom"	}
				]}
			/>
			<Stack class="max-w-5xl w-full">

				<PageHeading class="mb-12 text-neutral-softest"
					title="Location Settings"
					subtitle="Manage the Location Settings for this project."
					actions={[
						// { icon: "GearFine", theme: "neutral", href: route('locations.settings') },
						// { icon: "Plus", text: "New", theme: "accent", onclick: () => locations.create() },
					]}
				/>

				<Section id="overview" gap={6}>
					<Heading is="h3" as="h5">Overview</Heading>
					<LocationSettingsForm />
				</Section>

				<Separator class="my-12" />

				<Section id="media" gap={6}>
					<Heading is="h3" as="h5">Media</Heading>
					Media
				</Section>

				<Separator class="my-12" />

				<Section id="custom" gap={6}>
					<Heading is="h3" as="h5">Custom Fields</Heading>
					<p class="mb-3">These custom fields will apply to all locations in this project. If you want to add custom fields to all projects, visit your <Link href={route('user.settings')}>App Settings</Link> page.</p>

					{#if customFields?.length > 0}
						<Stack>
							<Flex align="center">
								<Inline class="font-style-label w-32">Name</Inline>
								<Inline class="font-style-label w-16">Type</Inline>
								<Inline class="font-style-label">Field</Inline>
							</Flex>
							{#each customFields as field}
								<Flex align="center" class="my-1">
									<Inline class="shrink-0 text-sm min-w-32">{field.label}</Inline>
									<Inline class="shrink-0 text-sm min-w-16 capitalize">{field.type}</Inline>
									<Input {...field} id={undefined} label={undefined} class="mr-2 w-full" />
									<Button class="ml-auto rounded-full"
										style="soft" theme="accent"
										icon="PencilSimple" iconSize="sm"
										onclick={() => modalActions.open('customField', { field })}
									/>
								</Flex>
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
				</Section>

			</Stack>
		</Flex>
	{/snippet}
</AuthenticatedLayout>