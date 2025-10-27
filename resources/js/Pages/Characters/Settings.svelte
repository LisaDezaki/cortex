<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout	 from '@/Layouts/AuthenticatedLayout.svelte'
	import CharacterSettingsForm from '@/Forms/Settings/CharacterSettings.svelte'
	import Flex   	  from '@/Components/Core/Flex.svelte'
	import Container  from '@/Components/UI/Container.svelte'
	import Heading    from '@/Components/UI/Heading.svelte'
	import Input      from '@/Components/UI/Input.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'
	import Section    from '@/Components/UI/Section.svelte'

	
	//	Page props

	const customFields = $page.props.customFields?.data
	const settings = $page.props.settings?.characters?.data

</script>



<svelte:head>
    <title>Character Settings</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			tabs={[
				{ label: "List",			href: route('characters') },
				{ label: "Collections", 	href: route('characters.collections') },
				{ label: "Settings", 		active: true },
			]}
		/>
	{/snippet}

	{#snippet article()}
		<Flex justify="center" gap={12} class="py-12">
			<PageMenu
				items={[
					{ icon: "UserList",       label: "Overview",      href: "#overview" },
					{ icon: "ImagesSquare",   label: "Media",         href: "#media"    },
					{ icon: "Textbox",        label: "Custom Fields", href: "#custom"   }
				]}
			/>
			<Container size="4xl">

				<Section id="overview" class="pb-12">
					<CharacterSettingsForm />
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

					{#each customFields as field}
						<Input type={field.type}
							name={field.name}
							label={field.label}
							options={field.options || null}
							placeholder={field.placeholder}
						/>
					{/each}

				</Section>

			</Container>
		</Flex>
	{/snippet}
</AuthenticatedLayout>