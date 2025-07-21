<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CustomFieldsPanel from '@/Partials/CustomFieldsPanel.svelte'
	import FactionTable from '@/Partials/FactionTable.svelte'

	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import Card from '@/Components/Card.svelte'
	import CardGrid from '@/Components/CardGrid.svelte'
	import Form from '@/Components/Form'
	import Heading from '@/Components/Heading.svelte'
	import Section from '@/Components/Section.svelte'

	let project = $page.props.active_project.data
	let factions = project?.factions

	let layoutType       = $state('grid')
	let selectionMode    = $state(false)
	let query            = $state('')
	let filteredFactions = $state(factions)
	let selectedFactions = $state([])

	function filterFactions(e) {
		filteredFactions = query.length == 0
			? factions
			: factions.filter(c => {
				let string = `${c.name} ${c.alias}`;
				return string.toLowerCase().includes(e.target.value.toLowerCase());
			})
	}

</script>

<svelte:head>
    <title>{project.name} Factions</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project", href: "/" },
			{ title: "Factions" }
		]} />
		<Button style="plain" theme="neutral" class="border-l"
			icon="GearFine" iconSize={24} iconWeight="light"
			href={route('factions.settings')}
		/>
		<Button style="plain" theme="accent" class="border-l"
			icon="Plus" iconSize={24} iconWeight="light"
			href={route('factions.create')}
		/>
	{/snippet}

	{#snippet article()}
		<Back href="/" />
		<Section class="space-y-6">
			<Heading is="h2" as="h4"
				heading="{project.name} Factions"
				subheading="View and manage the factions in your project."
			/>
			<div class="flex items-center mt-6">
				<Form.Input bind:value={query}
					icon="Search" name="search" placeholder="Search factions..."
					oninput={filterFactions}
				/>
				<Button class={layoutType == 'grid'  ? "text-emerald-500" : ""}
					icon="GridFour" iconSize={24} iconWeight="light"
					onclick={() => layoutType = 'grid'} 
				/>
				<Button class={layoutType == 'table' ? "text-emerald-500" : ""}
					icon="Table" iconSize={24} iconWeight="light"
					onclick={() => layoutType = 'table'}
				/>
			</div>
			{#if project && factions?.length > 0}
				{#if layoutType == 'table'}
					<FactionTable factions={filteredFactions} bind:selected={selectedFactions} {selectionMode} />
				{:else}
					<CardGrid class="xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3" items={filteredFactions}>
						{#snippet card(faction)}
							<Card
								class="aspect-square"
								image={faction.image_path}
								icon="FlagBannerFold"
								title={faction.name}
								subtitle="{faction.members.length} members"
								href={route('factions.show', {faction: faction.slug})}
							/>
						{/snippet}
					</CardGrid>
				{/if}
			{:else}
				<p class="mt-12">There are no factions for this project yet. <Link href={route('factions.create')}>Create one?</Link></p>
			{/if}
		</Section>
	{/snippet}

	{#snippet sidebar()}
		<CustomFieldsPanel />
	{/snippet}
    
</AuthenticatedLayout>