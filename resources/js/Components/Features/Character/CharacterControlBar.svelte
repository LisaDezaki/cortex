<script>
	//	Imports
	import ControlBar from '@/Components/UI/ControlBar.svelte'

	//	Props
	let {
		data = $bindable(),
		project,
		onUpdate,
		...restProps
	} = $props()

	//	Default values
	let query	= $state('')
	let filter	= $state('')
	let sort	= $state('name')
	let layout	= $state('grid')
	let size	= $state(8)
	const min	= $state(4)
	const max	= $state(12)

	let searchFunction 	= $state((ch) => query.length === 0 || ch.name.toLowerCase().includes(query.toLowerCase()))
	let filterFunction 	= $state((ch) => ch)
	let sortFunction 	= $derived( sortOptions.find((opt) => opt.value === sort)?.sortFunction )

	let filteredCharacters = $derived(data?.filter(filterFunction).filter(searchFunction).sort(sortFunction))

	//	Submenu Options
	let factionOptions = project.factions?.map(f => {
		return { label: f.name, value: `faction.${f.slug}`, image: f.image?.url, filterFunction: (ch) => { return ch.factions[0].slug == f.slug } }
	})
	let locationOptions = project.locations?.map(l => {
		return { label: l.name, value: `location.${l.slug}`, image: l.image?.url, filterFunction: (ch) => { return ch.location.slug == l.slug } }
	})
	let relationshipOptions = project.characters?.map(c => {
		return { label: c.name, value: `relationship.${c.slug}`, image: c.image?.url, filterFunction: (ch) => { return ch.relationships?.map(r => r.name).includes(filter.value) } }
	})
	let customFieldOptions = (field) => {
		return field.options?.map(opt => {
			return { label: opt.label, value: `${field.name}.${opt.value}`, filterFunction: (ch) => { return ch.customFieldValues.find(f => f.field?.label === filter.name)?.value !== filter.value } }
		})
	}

	//	Menu Options
	const filterOptions = $state([
		{ label: 'All Characters', 	value: '',			filterFunction: (ch) => { return ch } },
		{ label: 'Nameless',   		value: 'noname',	filterFunction: (ch) => { return ch.name === ''} },
		{ separator: true },
		{ label: 'In Faction...',			children: factionOptions },
		{ label: 'At Location...',			children: locationOptions },
		{ label: 'With Relationships...',	children: relationshipOptions },
		{ separator: true },
		...project.customFields?.map(f => {
			return { label: `${f.label}...`, children: customFieldOptions(f)}
		})
	])
	const sortOptions = $state([
		{ value: 'name',       label: "By name",		sortFunction: (a,b) => { return a.name 					< b.name					? -1 : 1 } },
		{ value: 'alias',      label: "By alias",		sortFunction: (a,b) => { return a.alias             	< b.alias					? -1 : 1 } },
		{ value: 'popularity', label: "By popularity",	sortFunction: (a,b) => { return a.relationships.length 	> b.relationships.length 	? -1 : 1 } },
		{ value: 'location',   label: "By location",	sortFunction: (a,b) => { return a.location?.name       	< b.location?.name 			? -1 : 1 } },
		{ value: 'faction',    label: "By faction",		sortFunction: (a,b) => { return a.factions?.[0]?.name  	< b.factions?.[0]?.name 	? -1 : 1 } },
		{ separator: true },
		{ value: 'created_at', label: "Date Created",	sortFunction: (a,b) => { return a.meta.createdAt		< b.meta.createdAt 			? -1 : 1 } },
		{ value: 'updated_at', label: "Date Updated",	sortFunction: (a,b) => { return a.meta.updatedAt		< b.meta.updatedAt 			? -1 : 1 } },
		{ value: 'random',     label: "Randomly",		sortFunction: (a,b) => { return Math.random()          	< 0.5 						? -1 : 1 } },
	])
	const layoutOptions = $state([
		{ icon: "Graph",    label: "As Graph",  value: "graph" },
		{ icon: "GridFour", label: "As Grid",   value: "grid"  },
		{ icon: "Table",    label: "As Table",  value: "table" }
	])

	const handleUpdate = (query,filter,sort,layout) => {
		onUpdate(filteredCharacters, {query,filter,sort,layout})
	}

</script>

<ControlBar
	bind:data	onUpdate={handleUpdate}
	bind:query	
	bind:filter	filterOptions={filterOptions}
	bind:sort	sortOptions={sortOptions}
	bind:layout	layoutOptions={layoutOptions}
	bind:size	{min} {max}
{...restProps} />

<pre>{JSON.stringify(sortOptions.find((opt) => opt.value === sort),null,3)}</pre>