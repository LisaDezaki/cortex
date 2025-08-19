<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import DeleteLocationForm from '@/Forms/Location/Delete.svelte'

	import { Grid, Inline, Stack } from '@/Components/Core'

	import ArticleBanner     from '@/Components/UI/ArticleBanner.svelte'
	import Back     from '@/Components/UI/Back.svelte'
	import Card     from '@/Components/UI/Card.svelte'
	import Container  from '@/Components/UI/Container.svelte'
	import Heading  from '@/Components/UI/Heading.svelte'
	import Modal    from '@/Components/UI/Modal.svelte'
	import PageHeader from '@/Components/UI/PageHeader.svelte'
	import PageMenu   from '@/Components/UI/PageMenu.svelte'
	import Section  from '@/Components/UI/Section.svelte'

	import Map        from '@/Components/Features/Location/Map.svelte'

	const location = $page.props.location.data

	let deletingLocation  = $state(false)

	function deleteLocation() {
        deletingLocation = true
    }
	function closeModal() {
		deletingLocation = false
    }

</script>

<svelte:head>
    <title>{location.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			breadcrumbs={[
				{ label: "Locations",   href: route('locations') },
			]}
			back={route('locations')}
			title={location.name}
			actions={[
				{ icon: "Pen",   href: route('locations.edit', { location: location.slug }) },
				{ icon: "Trash", onclick: deleteLocation, theme: "danger" }
			]}
		/>
	{/snippet}

	{#snippet article()}
		<Container size="7xl" class="flex gap-12 overflow-y-auto">

			<PageMenu class="py-12"
				items={[
					{ icon: "MapPinArea",   label: "Details",       href: "#bio",          active: $page.url.endsWith('#bio')          },
					{ icon: "Compass",      label: "Map",           href: "#map",          active: $page.url.endsWith('#map')          },
					{ icon: "UsersThree",   label: "People",        href: "#people",       active: $page.url.endsWith('#people')       },
					{ icon: "ImagesSquare", label: "Media",         href: "#media",        active: $page.url.endsWith('#media')        },
					{ icon: "Textbox",      label: "Custom Fields", href: "#customfields", active: $page.url.endsWith('#customfields') }
				]}
			/>

			<Stack gap={12} class="py-6 w-full">
				<Section id="bio">

					<ArticleBanner image={location.banner?.url}>
						{#if location.parent}
							<Inline class="relative">
								<Back icon="ArrowElbowUpLeft" href={route('locations.show', { location: location.parent.slug })} style="glass" />
								<span class="font-style-large text-white">{location.parent?.name}</span>
							</Inline>
						{/if}
			
						<Heading is="h1" as="h3" class="mt-auto z-10 {location.banner ? 'text-white' : ''}"
							heading={location.name}
							subheading={location.type}
						/>
					</ArticleBanner>
		
					<p class="mt-4 font-style-regular">
						{location.description}
					</p>
		
				</Section>

				<Section id="map">
					{#if location.map}
						<Map class="min-h-80 max-h-2xl rounded-lg" location={location} />
					{/if}
				</Section>

				{#if location.children.length > 0}
					<Section>
						<Heading is="h2" as="h5" class="mb-6"
							heading="Points of Interest"
						/>
						<Grid cols={3}>
							{#each location.children as loc}
								<Card aspect="video" class="w-full"
									icon={loc.icon || "MapPinArea"}
									image={loc.banner?.url}
									title={loc.name}
									subtitle={loc.type}
									href={route('locations.show', {location: loc.slug})}
								/>
							{/each}
						</Grid>
					</Section>
				{/if}
		
				{#if location.characters.length > 0}
					<Section>
						<Heading is="h2" as="h5" class="mb-6"
							heading="Characters"
						/>
						<Grid cols={5}>
							{#each location.characters as character}
								<Card aspect="square" class="w-full"
									icon="User"
									image={character.portrait?.url}
									title={character.name}
									subtitle={character.subtitle}
									href={route('characters.show', {character: character.slug})}
								/>
							{/each}
						</Grid>
					</Section>
				{/if}
			</Stack>
		</Container>
	{/snippet}

	<!-- {#snippet sidebar()}

		<div class="flex items-center justify-center aspect-video bg-slate-900/10 rounded-lg w-full border-b border-slate-900/15 overflow-hidden">
			{#if location.banner}
				<img src={location.banner?.url} alt={location.name} class="min-h-full min-w-full object-cover" />
			{:else}
				<Icon name="MapPin" size="xl" weight="thin" />
			{/if}
		</div>

		<div class="space-y-1.5 my-3 font-style-small">

			<div class="grid grid-cols-3 gap-3">
				<span class="col-span-1 font-bold text-right">Name</span>
				<span class="col-span-2">{location.name}</span>
			</div>

			{#if location.region}
				<div class="grid grid-cols-3 gap-3">
					<span class="col-span-1 font-bold text-right">Region</span>
					<span class="col-span-2">{location.region.name}</span>
				</div>
			{/if}

			{#if location.customFieldValues?.length > 0}
				{#each location.customFieldValues as field}
					<div class="grid grid-cols-3">
						<span class="col-span-1 px-2 py-1 font-bold border-r border-black/15 text-right">{field.field.label}</span>
						<span class="col-span-2 px-2 py-1">{field.value}</span>
					</div>
				{/each}
			{/if}
		</div>

	{/snippet} -->

</AuthenticatedLayout>

<Modal title="Delete {location.name}?" show={deletingLocation} onclose={closeModal}>
	<DeleteLocationForm {location} oncancel={closeModal} />
</Modal>