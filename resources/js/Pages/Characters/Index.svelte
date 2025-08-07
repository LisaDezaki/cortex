<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import CharacterGrid  from '@/Partials/CharacterGrid.svelte'
	import CharacterTable from '@/Partials/CharacterTable.svelte'

	import Back from '@/Components/Back.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import CharacterFilter from '@/Components/CharacterFilter.svelte'
	import Dropdown from '@/Components/Dropdown.svelte'
	import Form from '@/Components/Form.svelte'
	import HeaderButton from '@/Components/HeaderButton.svelte'
	import Heading from '@/Components/Heading.svelte'
	import Icon from '@/Components/Icon.svelte'
	import Input from '@/Components/Input.svelte'
	import Section from '@/Components/Section.svelte'
	import SetLayout from '@/Components/SetLayout.svelte'

	const activeProject = $page.props.activeProject.data
	const characters    = activeProject?.characters
	const factions      = activeProject?.factions
	const locations     = activeProject?.locations
	const customFields  = $page.props.customFields?.data

	let columns   = $state(['name', 'faction', 'relationships', 'location'])
	let filter    = $state('')
	let layout    = $state('grid')
	let query     = $state('')
	let rowSize   = $state(8)
	let sortBy    = $state('name')
	let sortOrder = $state('asc')

	let gridRows = $derived(16-rowSize)
	let hasFilter     = $derived(Boolean(filter))
	let characterList = $derived(
		characters
			.filter(c => {
				if (query.length > 0 && !c.name.toLowerCase().includes(query.toLowerCase())) { return false }
				// if (filter === 'faction' && c.factions[0]?.name !== filter.value) { return false }
				// if (filter === 'location' && c.location?.name !== filter.value) { return false }
				// if (filter === 'relationship' && !c.relationships?.map(r => r.name).includes(filter.value)) { return false }
				// if (!['Faction', 'Location', 'Relationship'].includes(filter.name) && filter.value && c.customFieldValues?.find(f => f.field?.label === filter.name)?.value !== filter.value) { return false }
				return true
			}).sort((a, b) => {
				if (sortBy === 'name') { return a.name > b.name ? 1 : -1 }
			})
	)
	let characterListSorted = $derived( sortOrder == 'asc' ? characterList : characterList.reverse())

	function mapToFilterItem(item) {
		return {
			label: (item.label || item.name),
			value: (item.slug || item.value)
		}
	}

	function removeFilter(index) {
		filter = {}
	}

</script>

<svelte:head>
    <title>{activeProject?.name} Characters</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet article()}
		<Back href="/" />
		<Section class="space-y-6">
			<Heading is="h2" as="h4"
				heading="Characters"
				actions={[
					{ label: "Settings",           icon: "GearFine", theme: "neutral", href: route('characters.settings')},
					{ label: "Create a character", icon: "Plus",     theme: "accent",  href: route('characters.create') },
				]}
			/>

			<div class="flex items-start gap-3">

				<!-- Search -->

				<Input type="search" bind:value={query} class="max-w-64"
					icon="MagnifyingGlass" name="search" placeholder="Search characters..."
				/>
				
				<!-- Filter -->

				<Dropdown class="w-52" contentClass="w-52" icon="FunnelSimple" label="All characters" bind:value={filter} options={[
					{ label: 'Nameless',   value: 'noname' },
					{ label: 'Incomplete', value: 'incomplete' },

					{ separator: true },

					{ label: 'Faction...', children: factions.map(f => {
						return { label: f.name, value: `faction.${f.slug}`, image: f.emblem?.url }
					}) },
					{ label: 'Location...', children: locations.map(l => {
						return { label: l.name, value: `location.${l.slug}`, image: l.banner?.url }
					}) },
					{ label: 'Relationships...', children: characters.map(c => {
						return { label: c.name, value: `relationship.${c.slug}`, image: c.portrait?.url }
					}) },
					...customFields.filter(f => f.type == 'select').map(f => {
						return { label: `${f.label}...`, children: f.options.map(o => {
							return { label: o.label, value: `${f.name}.${o.value}` }
						})}
					})
				]} />

				<!-- Sort -->

				<Input type="select" class="max-w-40" icon="SortAscending" placeholder="Sort by" bind:value={sortBy} options={[
					{ value: 'name',       label: "By name" },
					{ value: 'popularity', label: "By popularity" },
					{ value: 'location',   label: "By location name" },
					{ value: 'faction',    label: "Faction name" },
					{ value: 'created-at', label: "Date Created" },
					{ value: 'updated-at', label: "Date Updated" },
					{ value: 'random',     label: "Randomly" },
				]} />

				<!-- Result Count -->

				<div class="bg-emerald-500/10 text-emerald-500 rounded-lg p-2">{characterList.length} {characterList.length !== 1 ? 'results' : 'result'}</div>

				<!-- Advanced -->

				<!-- <Button style="plain" theme="accent"
					label="Advanced filters"
				/> -->

				<!-- Size-->

				<div class="inline-flex gap-1.5 ml-auto min-w-40 flex-shrink-0">

					{#if layout === 'graph'}
						<Icon name="MagnifyingGlass" size="md" />
						<Input type="slider" style="none" class="" showValue={false} min={4} max={12} bind:value={rowSize} />
					{:else if layout === 'grid'}
						<Icon name="Resize" size="md" />
						<Input type="slider" style="none" class="" showValue={false} min={4} max={12} bind:value={rowSize} />
					{:else if layout === 'table'}
						<Input type="select" multiple
							class="ml-auto"
							overrideLabel="Columns..."
							bind:value={columns}
							options={[
								{ value: 'faction',       label: "Faction" },
								{ value: 'relationships', label: "Relationships" },
								{ value: 'location',      label: "Location" },
								...customFields.map((field) => {
									return { value: field.name, label: field.label }
								})
							]}
						/>
					{/if}
				</div>

				<!-- Layout -->

				<Input type="select" class="w-32"
					bind:value={layout}
					options={[
						{ icon: "Graph",    label: "Graph",  value: "graph" },
						{ icon: "GridFour", label: "Grid",   value: "grid"  },
						{ icon: "Table",    label: "Table",  value: "table" }
					]}
				/>
				 
				<!-- <SetLayout bind:layout options={[
					{ icon: "GridFour", value: "grid"  },
					{ icon: "Table",    value: "table" }
				]} /> -->

			</div>

			<!-- Display Characters -->

			{#if activeProject && characters.length > 0}
				{#if layout === 'graph'}
					<p class="my-12 font-style-placeholder">This layout type isn't working yet. Try again later.</p>
				{:else if layout === 'grid'}
					<CharacterGrid characters={characterListSorted} cols={gridRows} showItemControls />
				{:else if layout === 'table'}
					<CharacterTable characters={characterListSorted} />
				{/if}
			{:else}
				<p class="mt-12">There are no characters for this project yet. <Link href={route('characters.create')}>Create one?</Link></p>
			{/if}
		</Section>
	{/snippet}

</AuthenticatedLayout>