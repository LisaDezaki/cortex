<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import LocationsPanel from '@/Partials/LocationsPanel.svelte'
	import DeleteLocationForm from '@/Forms/DeleteLocationForm.svelte'

	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import Card from '@/Components/Card.svelte'
	import Heading from '@/Components/Heading.svelte'
	import Icon from '@/Components/Icon.svelte'
	import Modal from '@/Components/Modal.svelte'
	import Section from '@/Components/Section.svelte'

	let project = $page.props.active_project.data
	let location = $page.props.location.data

	let deletingLocation = $state(false)

	function deleteLocation() {
        deletingLocation = true
    }
	function closeModal() {
		deletingLocation = false
    }

</script>

<svelte:head>
    <title>{project.name} / {location.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",    href: "/" },
			{ title: "Locations", href: route('locations') },
			{ title: location.name }
		]} />
		<Button plain iconSize={24} iconWeight="light" icon="Pen"   href={route('locations.edit',   {location: location.slug})} class="inline-flex items-center justify-center w-12 flex-shrink-0 aspect-square border-l hover:bg-slate-500/10" />
		<Button plain iconSize={24} iconWeight="light" icon="Trash" onclick={deleteLocation} class="inline-flex items-center justify-center w-12 flex-shrink-0 aspect-square border-l hover:bg-rose-500/10 text-rose-500" />
	{/snippet}

	{#snippet panel()}
		<LocationsPanel />
	{/snippet}

	{#snippet article()}

		<Back href={route('locations')} />

		<Section class="flex flex-col space-y-6 max-w-[40rem] mx-auto">

			<Heading is="h1" as="h3"
				heading={location.name}
				subheading={location.region?.name}
				class="mb-6"
			/>

			<p class="mt-4 font-style-regular">
				{location.description}
			</p>

		</Section>

		{#if location.characters.length > 0}
			<Section>
				<div class="px-8">
					<h4 class="font-style-h6 mb-2">Characters</h4>
					<div class="grid grid-cols-4 gap-2">
						{#each location.characters as character}
							<Card
								class="aspect-[3/4]"
								title={character.name}
								subtitle={character.subtitle}
								image={character.image_path}
								href={route('characters.show', {character: character.slug})}
							/>
						{/each}
					</div>
				</div>
			</Section>
		{/if}
	
	{/snippet}

	{#snippet sidebar()}

		<div class="flex items-center justify-center aspect-video bg-slate-900/10 rounded-lg w-full border-b border-slate-900/15 overflow-hidden">
			{#if location.image_path}
				<img src={location.image_path} alt={location.name} class="min-h-full min-w-full object-cover" />
			{:else}
				<Icon name="MapPin" size={64} weight="thin" />
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

			{#if location.custom_field_values?.length > 0}
				{#each location.custom_field_values as field}
					<div class="grid grid-cols-3">
						<span class="col-span-1 px-2 py-1 font-bold border-r border-black/15 text-right">{field.custom_field.label}</span>
						<span class="col-span-2 px-2 py-1">{field.value}</span>
					</div>
				{/each}
			{/if}
		</div>

	{/snippet}

</AuthenticatedLayout>

<Modal show={deletingLocation} onclose={closeModal}>
	<DeleteLocationForm {location} oncancel={closeModal} />
</Modal>