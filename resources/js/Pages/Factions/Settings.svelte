<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionSettingsForm from '@/Forms/Settings/FactionSettings.svelte'
	import Flex   	  from '@/Components/Core/Flex.svelte'
	import Inline     from '@/Components/Core/Inline.svelte'
	import Stack   	  from '@/Components/Core/Stack.svelte'
	import Button  	  from '@/Components/UI/Button.svelte'
	import Heading    from '@/Components/UI/Heading.svelte'
	import Input      from '@/Components/UI/Input.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'
	import Section    from '@/Components/UI/Section.svelte'
	import Separator  from '@/Components/UI/Separator.svelte'
	import { modalActions } from '@/stores/modalStore'

	const customFields = $page.props.customFields?.data
	const settings     = $page.props.settings?.factions?.data

</script>



<svelte:head>
    <title>Faction Settings</title>
</svelte:head>

<AuthenticatedLayout>
	{#snippet article()}
		<Section size="5xl" gap={0} class="h-full overflow-hidden">


			<PageHeader class="px-6 py-2"
				title="Faction Settings"
				tabs={[
					{ text: "Faction List",		href: route('factions') },
					{ text: "Settings", 		active: true },
				]}
			/>

			<Flex gap={12} class="px-6 py-6 w-full">
				<PageMenu
					items={[
						{ icon: "UserList",       label: "Overview",      href: "#overview"	},
						{ icon: "ImagesSquare",   label: "Media",         href: "#media"	},
						{ icon: "Textbox",        label: "Custom Fields", href: "#custom"	}
					]}
				/>
				<Stack>

					<Section id="overview" class="pb-12">
						<FactionSettingsForm />
					</Section>

					<Section id="media" class="pb-12">
						<Flex align="center" class="mb-6 max-w-[32ch]">
							<Heading is="h4" as="h6">Media</Heading>
						</Flex>
						Media
					</Section>

					<Section id="custom" class="pb-12">
						<Flex align="center" class="mb-6 max-w-[32ch]">
							<Heading is="h4" as="h6">Custom Fields</Heading>
						</Flex>
						<p class="mb-3">These custom fields will apply to all factions in this project. If you want to add custom fields to all projects, visit your <Link href={route('user.settings')}>App Settings</Link> page.</p>

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
		</Section>
	{/snippet}

	{#snippet sidebar()}
		<div class="bg-slate-50 min-w-80 shadow-lg"></div>
	{/snippet}
</AuthenticatedLayout>