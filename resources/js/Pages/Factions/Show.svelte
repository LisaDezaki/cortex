<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionsPanel from '@/Partials/FactionsPanel.svelte'
	import DeleteFactionForm from '@/Forms/Faction/Delete.svelte'

	import { Flex, Grid, Stack } from '@/Components/Core'

	import Back         from '@/Components/UI/Back.svelte';
	import Button       from '@/Components/UI/Button.svelte';
	import Card         from '@/Components/UI/Card.svelte';
	import Heading      from '@/Components/UI/Heading.svelte'
	import Icon         from '@/Components/UI/Icon.svelte'
	import Modal        from '@/Components/UI/Modal.svelte'
	import Section      from '@/Components/UI/Section.svelte'

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
			<Heading is="h1" as="h3" class="my-12"
				eyebrowIcon="FlagBannerFold" eyebrow="Faction"
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
					<span class="bg-slate-500/10 font-style-large px-2 py-1 rounded-full">
						{rank.name}
					</span>
					<Grid cols={5} class="mt-2">
						{#each faction.members.filter(m => m.rank.id == rank.id) as member}
							<Card
								aspect="square"
								title={member.name}
								subtitle={member.rank.name}
								icon="User"
								image={member.portrait?.url}
								href={route('characters.show', {character: member.slug})}
							/>
						{/each}
					</Grid>
				{/each}
			</Section>
		{/if}

	{/snippet}

	{#snippet sidebar()}

		<Flex align="center" justify="center" class="aspect-square bg-slate-900/10 rounded-lg  border-slate-900/15 overflow-hidden max-w-64 mx-auto w-[80%]">
			{#if faction.emblem}
				<img src={faction.emblem.url} alt={faction.slug} class="w-full rounded-t-lg" />
			{:else}
				<Icon name="FlagBannerFold" size="xl" weight="thin" />
			{/if}
		</Flex>

		<Stack gap={1.5} class="py-3">

			{#if faction.headquarters}
				<Flex gap={3}>
					<span class="font-bold w-20">HQ</span>
					<Link class="line-clamp-1 text-emerald-500 hover:underline"
						href={route('locations.show', {location: faction.headquarters.slug})}
					>{faction.headquarters.name}</Link>
				</Flex>
			{/if}

			<Flex gap={3}>
				<span class="font-bold w-20">Leader</span>
				<Link class="line-clamp-1 text-emerald-500 hover:underline"
					href
				></Link>
			</Flex>

			{#if location.customFieldValues?.length > 0}
				{#each location.customFieldValues as field}
					<Flex gap={3}>
						<span class="font-bold w-20">{field.field.label}</span>
						<span class="line-clamp-1">{field.value}</span>
					</Flex>
				{/each}
			{/if}
		</Stack>

	{/snippet}
	
</AuthenticatedLayout>

<Modal title="Delete {faction.name}?" show={deletingFaction} onclose={closeModal}>
	<DeleteFactionForm {faction} oncancel={closeModal} />
</Modal>