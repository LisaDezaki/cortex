<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import FactionGrid from '@/Partials/FactionGrid.svelte'
	import FactionTable from '@/Partials/FactionTable.svelte'

	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form.svelte'
	import HeaderButton from '@/Components/HeaderButton.svelte'
	import Heading from '@/Components/Heading.svelte'
	import Icon from '@/Components/Icon.svelte'
	import Input from '@/Components/Input.svelte'
	import Section from '@/Components/Section.svelte'
	import SetLayout from '@/Components/SetLayout.svelte'

	const activeProject = $page.props.activeProject.data
	const factions = activeProject?.factions
	const customFields  = $page.props.customFields?.data

	let columns   = $state(['name', 'members', 'headquarters'])
	let filter    = $state({})
	let layout    = $state('grid')
	let query     = $state('')
	let rowSize   = $state(8)
	let sortBy    = $state('name')
	let sortOrder = $state('asc')

	let filteredFactions = $state(factions)
	let selectedFactions = $state([])

	let gridRows      = $derived(16-rowSize)
	let hasFilter     = $derived(Boolean(filter.name && filter.value))
	let factionList = $derived(
		factions
			.filter(c => {
				if (query.length > 0 && !c.name.toLowerCase().includes(query.toLowerCase())) { return false }
				// if (hasFilter && filter.name === 'Faction' && c.factions[0]?.name !== filter.value) { return false }
				return true
			}).sort((a, b) => {
				if (sortBy === 'name') { return a.name > b.name ? 1 : -1 }
			})
	)

	let factionListSorted = $derived( sortOrder == 'asc' ? factionList : factionList.reverse())

	// function filterFactions(e) {
	// 	filteredFactions = query.length == 0
	// 		? factions
	// 		: factions.filter(c => {
	// 			let string = `${c.name} ${c.alias}`;
	// 			return string.toLowerCase().includes(e.target.value.toLowerCase());
	// 		})
	// }

</script>

<svelte:head>
    <title>{activeProject?.name} Factions</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet article()}
		<Back href="/" />
		<Section class="space-y-6">
			<Heading is="h2" as="h4"
				heading="Factions"
				actions={[
					{ label: "Settings",         icon: "GearFine", theme: "neutral", href: route('factions.settings')},
					{ label: "Create a faction", icon: "Plus",     theme: "accent",  href: route('factions.create') },
				]}
			/>
			<div class="flex items-start gap-3">

				<!-- Search -->

				<Input type="search" bind:value={query} class="max-w-64"
					icon="MagnifyingGlass" name="search" placeholder="Search factions..."
				/>

				<!-- Filter -->

				<!-- <CharacterFilter bind:filter /> -->

				<!-- Sort -->

				<Input type="select" class="max-w-40" icon="SortAscending" placeholder="Sort by" bind:value={sortBy} options={[
					{ value: 'name',         label: "By name" },
					{ value: 'members',      label: "By member count" },
					{ value: 'created-at',   label: "Date Created" },
					{ value: 'updated-at',   label: "Date Updated" },
					{ value: 'random',       label: "Randomly" },
				]} />

				<!-- Result Count -->

				<div class="bg-emerald-500/10 text-emerald-500 rounded-lg p-2">{factionList.length} {factionList.length !== 1 ? 'results' : 'result'}</div>

				<!-- Size-->

				<div class="inline-flex gap-1.5 ml-auto min-w-40 flex-shrink-0">
					{#if layout === 'grid'}
						<Icon name="Resize" size={24} />
						<Form.Slider class="" showValue={false} min={4} max={12} bind:value={rowSize} />
					{:else if layout === 'table'}
						<Input type="select" class="ml-auto" multiple overrideLabel="Columns" bind:value={columns} options={[
							{ value: 'name',         label: "Name" },
							{ value: 'members',      label: "Members" },
							{ value: 'headquarters', label: "Headquarters" },
							// ...customFields.map((field) => {
							// 	return { value: field.name, label: field.label }
							// })
						]} />
					{/if}
				</div>

				<!-- Layout -->

				<SetLayout bind:layout options={[
					{ icon: "GridFour", value: "grid"  },
					{ icon: "Table",    value: "table" }
				]} />

			</div>
			{#if activeProject && factions?.length > 0}
				{#if layout == 'grid'}
					<FactionGrid factions={filteredFactions} cols={gridRows} showItemControls />
				{:else if layout == 'table'}
					<FactionTable factions={filteredFactions} />
				{/if}
			{:else}
				<p class="mt-12">There are no factions for this project yet. <Link href={route('factions.create')}>Create one?</Link></p>
			{/if}
		</Section>
	{/snippet}
    
</AuthenticatedLayout>