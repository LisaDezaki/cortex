<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionTable from './Partials/FactionTable.svelte'
	import Article from '@/Components/Article.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Card from '@/Components/Card.svelte';
	import CardGrid from '@/Components/CardGrid.svelte';
	import Form from '@/Components/Form'
	import Modal from '@/Components/Modal.svelte'

	let project = $page.props.active_project.data
	let factions = project?.factions
	let custom_fields = project?.custom_fields

	let creatingFactions = $state(false)
	let layoutType       = $state('grid')
	let selectionMode    = $state(false)
	let query            = $state('')
	let filteredFactions = $state(factions)
	let selectedFactions = $state([])

	function createFaction() {
        creatingFaction = true
    }
	function closeModal() {
        creatingFaction = false
    }

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
		<Button icon="Plus" iconSize={24} href={route('factions.create')} class="border-l w-14 hover:bg-emerald-500/10 hover:text-emerald-500" />
	{/snippet}

	<section class="grid grid-cols-5 gap-12 px-12 py-6">
		<div class="col-span-3 space-y-6">

			<Article
				title="{project.name} Factions"
				subtitle="View and manage the factions in your project."
				bodyclass="space-y-6"
				actions={[
					{
						icon: "Plus",
						href: route('factions.create'),
					},
					{
						icon: "GearFine",
						href: route('factions.settings')
					}
				]}
			>
				<div class="flex items-center mt-6 px-6">
					<Form.Input icon="Search" name="search" placeholder="Search factions..." bind:value={query} oninput={filterFactions} />
					<Button plain iconSize={24} icon="GridFour" onclick={() => layoutType = 'grid'}  class={layoutType == 'grid'  ? "text-emerald-500" : ""} />
					<Button plain iconSize={24} icon="Table"    onclick={() => layoutType = 'table'} class={layoutType == 'table' ? "text-emerald-500" : ""} />
				</div>
	
				<!-- <pre>{JSON.stringify(factions, null, 2)}</pre> -->
	
				{#if project && factions?.length > 0}
					<div class="flex flex-col gap-4">
						{#if layoutType == 'table'}
							<FactionTable factions={filteredFactions} bind:selected={selectedFactions} {selectionMode} />
						{:else}
							<CardGrid class="xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 px-6" items={filteredFactions}>
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
					</div>
				{/if}
			</Article>

		</div>
		<div class="col-span-2 space-y-6">

			<Button
				primary
				class="w-full"
				icon="Plus"
				label="Create a new faction"
				href={route('factions.create')}
			/>

			<Article
				title="Custom Fields"
				subtitle="for Factions"
			>
				<Form class="flex flex-col items-center space-y-3">
					{#each custom_fields.filter(f => f.entity === 'faction') as field}
						<Form.Field class="w-full" {...field} />	
					{/each}
					<Button
						plain
						class="bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-500 rounded-lg font-style-button"
						icon="Plus"
						label="Add a custom field"
					/>
				</Form>
			</Article>

		</div>

	</section>
    
</AuthenticatedLayout>