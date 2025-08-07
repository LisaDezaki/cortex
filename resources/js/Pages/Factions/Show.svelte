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
	import HeaderButton from '@/Components/HeaderButton.svelte';
	import Heading from '@/Components/Heading.svelte'
	import Icon from '@/Components/Icon.svelte'
	import Modal from '@/Components/Modal.svelte'
	import Section from '@/Components/Section.svelte'

	const activeProject = $page.props.activeProject.data
	const faction = $page.props.faction.data

	let deletingFaction = $state(false)

	function deleteFaction() {
        deletingFaction = true
    }
	function closeModal() {
		deletingFaction = false
    }

</script>

<svelte:head>
    <title>{activeProject.name} / {faction.name}</title>
</svelte:head>

<AuthenticatedLayout>

	<!-- {#snippet header()}
		<Breadcrumbs data={[
			{ title: "Factions",   href: route('factions') },
			{ title: faction.name }
		]} />
		<Button icon="Pen"   theme="neutral" href={route('factions.edit', {faction: faction.slug})} />
		<Button icon="Trash" theme="danger"  onclick={deleteFaction} />
	{/snippet} -->

	{#snippet panel()}
		<FactionsPanel />
	{/snippet}

	{#snippet article()}
		<Back href={route('factions')} />
		<Section>
			<Heading is="h1" as="h3" class="mb-6"
				heading={faction.name}
				actions={[
					{ label: "Edit",   icon: "Pen",   href: route('factions.edit', {faction: faction.slug}) },
					{ label: "Delete", icon: "Trash", onclick: deleteFaction, theme: "danger" }
				]}
			/>
			<p>{faction.description}</p>
		</Section>

		{#if faction.ranks.length > 0}
			<Section title="Membership">
				{#each faction.ranks as rank}
					<div class="font-style-large mb-1.5">
						{rank.name}
					</div>
					<div class="flex gap-1.5 mb-6 pb-6 border-b">
						{#each faction.members.filter(m => m.rank.id == rank.id) as member}
							<Card
								class="aspect-[3/4] w-28"
								title={member.name}
								subtitle={member.rank.name}
								image={member.portrait?.url}
								href={route('characters.show', {character: member.slug})}
							/>
						{/each}
					</div>
				{/each}
			</Section>
		{/if}

	{/snippet}

	{#snippet sidebar()}

		<div class="mx-auto flex items-center justify-center aspect-square bg-slate-900/10 rounded-lg  border-slate-900/15 overflow-hidden max-w-64 w-[80%]">
			{#if faction.emblem}
				<img src={faction.emblem.url} alt={faction.slug} class="w-full rounded-t-lg" />
			{:else}
				<Icon name="FlagBannerFold" size={64} weight="thin" />
			{/if}
		</div>

		<div class="space-y-1.5 py-3">
			{#if faction.headquarters}
				<div class="grid grid-cols-3 gap-3">
					<span class="col-span-1 font-bold">HQ</span>
					<Link class="col-span-2 line-clamp-1 text-emerald-500 hover:underline"
						href={route('locations.show', {location: faction.headquarters.slug})}
					>{faction.headquarters.name}</Link>
				</div>
			{/if}
			<div class="grid grid-cols-3 gap-3">
				<span class="col-span-1 font-bold">Leader</span>
				<Link class="col-span-2 line-clamp-1 text-emerald-500 hover:underline"
					href
				></Link>
			</div>
		</div>

		<section>
			<Heading is="h3" as="h6"
				heading="Custom Fields"
				class="mt-6 mb-6"
			/>
			{#if location.customFieldValues?.length > 0}
				{#each location.customFieldValues as field}
					<div class="grid grid-cols-2">
						<span class="col-span-1 px-2 py-1 font-bold border-r border-slate-500/15 text-right">{field.field.label}</span>
						<span class="col-span-1 px-2 py-1">{field.value}</span>
					</div>
				{/each}
			{:else}
				No custom fields
			{/if}
		</section>

		{#each faction.customFieldValues as field}
			<div class="grid grid-cols-2">
				<span class="col-span-1 px-2 py-1 font-bold border-r border-slate-500/15 text-right">{field.field.label}</span>
				<span class="col-span-1 px-2 py-1">{field.value}</span>
			</div>
		{/each}

	{/snippet}
	
</AuthenticatedLayout>