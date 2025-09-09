<script>
	//	Imports
	import { page } from '@inertiajs/svelte'
	import { Flex, Inline } from '@/Components/Core'
	import ControlBar from '@/Components/UI/ControlBar.svelte'

	const customFields = $page.props.customFields?.data

	//	Props
	let {
		data,
		filteredData = $bindable(),
		project,
		onUpdate,
		...restProps
	} = $props()

	//	Default values
	let query	= $state('')
	let filter	= $state('')
	let sort	= $state('name')
	let sortDir = $state('asc')
	let layout	= $state('grid')
	let size	= $state(8)
	const min	= $state(4)
	const max	= $state(12)

	//	Submenu Options
	let factionOptions = project.factions?.map(f => {
		return { label: f.name, value: `factions.*.${f.slug}`, image: f.image?.url, filterFunction: (ch) => { return ch.factions[0].slug == f.slug } }
	})
	let locationOptions = project.locations?.map(l => {
		return { label: l.name, value: `location.${l.slug}`, image: l.image?.url, filterFunction: (ch) => { return ch.location.slug == l.slug } }
	})
	let relationshipOptions = project.characters?.map(c => {
		return { label: c.name, value: `relationship.*.${c.slug}`, image: c.image?.url, filterFunction: (ch) => { return ch.relationships?.map(r => r.name).includes(filter.value) } }
	})
	let customFieldOptions = (field) => {
		return field.options?.map(opt => {
			return { label: opt.label, value: `${field.name}.${opt.value}`, filterFunction: (ch) => { return ch.customFieldValues.find(f => f.field?.label === filter.name)?.value !== filter.value } }
		})
	}

	//	TODO:	Hopefully the filterFunction and sortFunction properties will
	// 			not be necessary after refactoring the ControlBar component,
	//			but specific examples may remain like "random"

	//	Menu Options
	const filterOptions = $state([
		{ label: 'All Characters', 	value: '',		filterFunction: (ch) => { return ch } },
		{ 	separator: true },
		{ label: 'Faction...',		children: factionOptions },
		{ label: 'Location...',		children: locationOptions },
		{ label: 'Relationship...',	children: relationshipOptions },
		{ 	separator: true },
		...customFields?.map(f => {
			return { label: `${f.label}...`, children: customFieldOptions(f) }
		})
	])
	const sortOptions = $state([
		{ label: "By name",			value: 'name',       sortFunction: (a,b) => { return a.name 				< b.name					? -1 : 1 } },
		{ label: "By alias",		value: 'alias',      sortFunction: (a,b) => { return a.alias             	< b.alias					? -1 : 1 } },
		{ label: "By popularity",	value: 'popularity', sortFunction: (a,b) => { return a.relationships.length > b.relationships.length 	? -1 : 1 } },
		{ label: "By location",		value: 'location',   sortFunction: (a,b) => { return a.location?.name       < b.location?.name 			? -1 : 1 } },
		{ label: "By faction",		value: 'faction',    sortFunction: (a,b) => { return a.factions?.[0]?.name  < b.factions?.[0]?.name 	? -1 : 1 } },
		...customFields?.map(f => {
			return { label: `By ${f.label.toLowerCase()}`, value: f.name }
		}),
		{ 	separator: true },
		{ label: "Date Created",	value: 'created_at', sortFunction: (a,b) => { return a.meta.createdAt		< b.meta.createdAt 			? -1 : 1 } },
		{ label: "Date Updated",	value: 'updated_at', sortFunction: (a,b) => { return a.meta.updatedAt		< b.meta.updatedAt 			? -1 : 1 } },
		{ label: "Randomly",		value: 'random',     sortFunction: (a,b) => { return Math.random()          < 0.5 						? -1 : 1 } },
	])
	const layoutOptions = $state([
		{ label: "As Graph",  		value: "graph",		icon: "Graph"	 },
		{ label: "As Grid",   		value: "grid",		icon: "GridFour" },
		{ label: "As Table",  		value: "table",		icon: "Table"	 }
	])

</script>

<ControlBar
	bind:filteredData data={data}
	bind:query
	bind:filter	filterOptions={filterOptions}
	bind:sort bind:sortDir sortOptions={sortOptions}
	bind:layout	layoutOptions={layoutOptions}
	bind:size	{min} {max}
{...restProps} />