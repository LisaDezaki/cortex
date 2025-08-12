<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import LocationsPanel from '@/Partials/LocationsPanel.svelte'
	
	import DeleteLocationForm from '@/Forms/Location/Delete.svelte'
	import NewLocationForm    from '@/Forms/Location/LocationNew.svelte'

	import Grid     from '@/Components/Core/Grid.svelte'

	import Back     from '@/Components/UI/Back.svelte'
	import Button   from '@/Components/UI/Button.svelte'
	import Card     from '@/Components/UI/Card.svelte'
	import Heading  from '@/Components/UI/Heading.svelte'
	import Icon     from '@/Components/UI/Icon.svelte'
	import Modal    from '@/Components/UI/Modal.svelte'
	import Section  from '@/Components/UI/Section.svelte'

	const activeProject = $page.props.activeProject.data
	const location = $page.props.location.data

	let locationModalOpen = $state(false)
	let deletingLocation  = $state(false)

	function openLocationModal(location) {
        locationModalOpen = true
    }
	function deleteLocation() {
        deletingLocation = true
    }
	function closeModal() {
		locationModalOpen = false
		deletingLocation = false
    }

</script>

<svelte:head>
    <title>{location.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet panel()}
		<LocationsPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('locations')} />
		<Section>

			<Heading is="h1" as="h3" class="my-12"
				eyebrowIcon="MapPin" eyebrow="Location"
				heading={location.name}
				subheading={location.region?.name}
				
				actions={[
					{ label: "Edit",   icon: "Pen",   onclick: openLocationModal },
					{ label: "Delete", icon: "Trash", onclick: deleteLocation, theme: "danger" }
				]}
			/>

			<p class="mt-4 font-style-regular">
				{location.description}
			</p>

		</Section>

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
	
	{/snippet}

	{#snippet sidebar()}

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

	{/snippet}

</AuthenticatedLayout>

<Modal title="Edit Location" show={locationModalOpen} onclose={closeModal}>
	<NewLocationForm locationData={location} oncancel={closeModal} />
</Modal>

<Modal title="Delete {location.name}?" show={deletingLocation} onclose={closeModal}>
	<DeleteLocationForm {location} oncancel={closeModal} />
</Modal>