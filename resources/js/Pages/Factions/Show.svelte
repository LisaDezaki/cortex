<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionsPanel from '@/Partials/FactionsPanel.svelte'
	import DeleteFactionForm from '@/Forms/DeleteFactionForm.svelte'

	import Back from '@/Components/Back.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Card from '@/Components/Card.svelte';
	import Heading from '@/Components/Heading.svelte'
	import Icon from '@/Components/Icon.svelte'
	import Modal from '@/Components/Modal.svelte'
	import Section from '@/Components/Section.svelte'

	let project = $page.props.active_project.data
	let faction = $page.props.faction.data

	let deletingFaction = $state(false)

	function deleteFaction() {
        deletingFaction = true
    }
	function closeModal() {
		deletingFaction = false
    }

</script>

<svelte:head>
    <title>{project.name} / {faction.name}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",    href: "/" },
			{ title: "Factions", href: route('factions') },
			{ title: faction.name }
		]} />
		<Button style="plain" theme="neutral" class="border-l"
			iconSize={24} iconWeight="light" icon="Pen"   
			href={route('factions.edit', {faction: faction.slug})} 
		/>
		<Button style="plain" theme="danger" class="border-l"
			iconSize={24} iconWeight="light" icon="Trash" 
			onclick={deleteFaction} 
	/>
	{/snippet}

	{#snippet panel()}
		<FactionsPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('factions')} />
		<Section>
			<Heading is="h1" as="h3"
				heading={faction.name}
				subheading="Faction Details"
				class="mb-6"
			/>
			<div>
				<h6 class="font-bold mb-3">Description</h6>
				<p>{faction.description}</p>
			</div>
		</Section>

		<Section
			title="Ranks"
			subtitle="Every faction has some kind of hierarchy, and these are the different levels of hierarchy in this faction."
		>
			<!-- <Heading is="h2" as="h5"
				heading="Ranks"
				subheading="Every faction has some kind of hierarchy, and these are the different levels of hierarchy in this faction."
				class="mb-6"
			/> -->
			<div class="flex gap-3">
				{#each faction.ranks as rank}
					<div class="bg-slate-200 px-3 py-1.5 rounded-md">
						{rank.name}
					</div>
				{/each}
			</div>
		</Section>

	{/snippet}

	{#snippet sidebar()}

		<div class="mx-auto flex items-center justify-center aspect-square bg-slate-900/10 rounded-lg  border-slate-900/15 overflow-hidden max-w-64 w-[80%]">
			{#if faction.image_path}
				<img src={faction.image_path} alt={faction.slug} class="w-full rounded-t-lg" />
			{:else}
				<Icon name="FlagBannerFold" size={64} weight="thin" />
			{/if}
		</div>

		<div class="space-y-1.5 px-6 py-3">
			{#if faction.headquarters}
				<div class="grid grid-cols-2 gap-3">
					<span class="col-span-1 font-bold text-right">HQ</span>
					<Link class="col-span-1 line-clamp-1 text-emerald-500 hover:underline" href={route('locations.show', {location: faction.headquarters.slug})}>{faction.headquarters.name}</Link>
				</div>
			{/if}
		</div>

		<section>
			<Heading is="h3" as="h6"
				heading="Members"
				class="mt-6 mb-6"
			/>
			{#each faction.ranks as rank}
				<div class="font-bold mt-3 mb-2">{rank.name}</div>
				<div class="flex flex-wrap justify-start gap-3 overflow-y-auto w-full">
					{#each faction.members.filter(m => m.rank.id == rank.id) as member}
						<Card
							class="aspect-[3/4]"
							title={member.name}
							subtitle={member.rank.name}
							image={member.image_path}
							href={route('characters.show', {character: member.slug})}
						/>
					{/each}
				</div>
			{/each}
		</section>

		<section>
			<Heading is="h3" as="h6"
				heading="Custom Fields"
				class="mt-6 mb-6"
			/>
			{#if location.custom_field_values?.length > 0}
				{#each location.custom_field_values as field}
					<div class="grid grid-cols-2">
						<span class="col-span-1 px-2 py-1 font-bold border-r border-slate-500/15 text-right">{field.custom_field.label}</span>
						<span class="col-span-1 px-2 py-1">{field.value}</span>
					</div>
				{/each}
			{:else}
				No custom fields
			{/if}
		</section>

		{#each faction.custom_field_values as field}
			<div class="grid grid-cols-2">
				<span class="col-span-1 px-2 py-1 font-bold border-r border-slate-500/15 text-right">{field.custom_field.label}</span>
				<span class="col-span-1 px-2 py-1">{field.value}</span>
			</div>
		{/each}

	{/snippet}
	
</AuthenticatedLayout>