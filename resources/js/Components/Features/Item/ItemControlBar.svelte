<script>
	import { onMount } from 'svelte'
	import { page } from '@inertiajs/svelte'


	//	Layout & Components

	import ControlBar from '@/Components/UI/ControlBar.svelte'


	//	Page & Component props

	const customFields = $page.props.customFields?.data

	let {
		class: className,
		data, project,
		query	= $bindable(''),
		filter	= $bindable(''),
		sort	= $bindable('name'),
		size	= $bindable(8),
		layout  = $bindable('grid'),
		results = $bindable([]),
		...restProps
	} = $props()


	//	Default values

	const min	= $state(6)
	const max	= $state(11)

	let filterOption    = $derived(filterOptions.find(opt => opt.value === filter) || '')
	let sortOption		= $derived(  sortOptions.find(opt => opt.value === sort)   || '')

	// let filterFunction	= $derived((ch)  => { return ch })
	// let sortFunction	= $derived((a,b) => { return a.name < b.name ? -1 : 1})

	onMount(() => {
		filterOption    = filterOptions.find(opt => opt.value === filter) || ''
		sortOption		= sortOptions.find(opt => opt.value === sort)   || ''
		results = data.filter(query, filterOption.filterFunction, sortOption.sortFunction)
	})

	function onUpdate(type, option) {
		if (type === 'filter') 	{ filterOption = option }
		if (type === 'sort') 	{ sortOption   = option }
		results = data.filter(query, filterOption.filterFunction, sortOption.sortFunction)
	}

	function customFilterFunction(ch) {
		return ch.customFieldValues.find(f => f.field?.name === filter.split('.')[0])?.value === filter.split('.')[1]
	}

	function customSortFunction(a,b,f) {
		if (!isNaN(a.customFieldValues.find(v => v.name === f.name)?.value)) {
			return Number(a.customFieldValues.find(v => v.name === f.name)?.value) < Number(b.customFieldValues.find(v => v.name === f.name)?.value) ? -1 : 1
		}
		return a.customFieldValues.find(v => v.name === f.name)?.value < b.customFieldValues.find(v => v.name === f.name)?.value ? -1 : 1
	}


	//	Submenu Options

	// let factionOptions = project.factions?.items?.map(f => {
	// 	return { label: f.name, value: `factions.*.${f.slug}`, 		imageIcon: 'FlagBannerFold',	image: f.image?.url || '', filterFunction: (ch) => { return ch.factions[0]?.slug == f.slug } }
	// })

	// let locationOptions = project.locations?.items?.map(l => {
	// 	return { label: l.name, value: `location.${l.slug}`, 		imageIcon: 'MapPinArea',		image: l.image?.url || '', filterFunction: (ch) => { return ch.location?.slug == l.slug } }
	// })

	// let relationshipOptions = project.characters?.items?.map(c => {
	// 	return { label: c.name, value: `relationship.*.${c.slug}`, 	imageIcon: 'User',			image: c.image?.url || '', filterFunction: (ch) => { return ch.relationships?.items?.map(r => r.slug).includes(filter.split('.')[2]) } }
	// })

	let customFieldOptions = (field) => {
		return field.options?.map(opt => {
			return { label: opt.label, value: `${field.name}.${opt.value}`, filterFunction: (ch) => { return ch.customFieldValues.find(f => f.field?.name === filter.split('.')[0])?.value === filter.split('.')[1] } }
		})
	}


	/**
	 *  Menu Options
	 * 
	 *  - Filter Options
	 *  - Sort Options
	 *  - Layout Options
	 * 
	 */

	const filterOptions = $state([
		{ label: 'All items', 	value: '',		  	filterFunction: (i) => { return i } },
		{ label: 'Starred', 	value: 'starred', 	filterFunction: (i) => { return i.starred } },
		{ label: 'Unique', 		value: 'unique', 	filterFunction: (i) => { return i.unique } },
		{ 	separator: true },
		{ label: 'Type',			options: [...new Set($page.props.activeProject?.data.items.map(i => i.type))].map(t => {
			return { label: t, value: t.toLowerCase(), filterFunction: i => i.type === t }
		}) },
		{ 	separator: true, hideIf: !customFields || customFields.length === 0 },
		...customFields?.map(f => {
			return { label: f.label, options: customFieldOptions(f) || [] }
		})
	])

	const sortOptions = $state([
		{ label: "By name", value: 'name', sortFunction: (a,b) => {
			return a.name < b.name ? -1 : 1 } },
		{ label: "By type", value: 'type', sortFunction: (a,b) => {
			return a.type < b.type ? -1 : 1 } },
		{ label: "By cost", value: 'cost', sortFunction: (a,b) => {
			return a.cost < b.cost ? -1 : 1 } },
		{ label: "By weight", value: 'weight', sortFunction: (a,b) => {
			return a.weight < b.weight ? -1 : 1 } },
		{ separator: true },
		...customFields?.map(f => {
			return { label: `By ${f.label.toLowerCase()}`, value: f.name, sortFunction: (a,b) => customSortFunction(a,b,f) }
		}),
		{ separator: true },
		{ label: "Date Created", value: 'created_at', sortFunction: (a,b) => {
			return a.meta.createdAt < b.meta.createdAt ? -1 : 1 } },
		{ label: "Date Updated", value: 'updated_at', sortFunction: (a,b) => {
			return a.meta.updatedAt < b.meta.updatedAt ? -1 : 1 } },
		{ label: "Randomly", value: 'random',     sortFunction: (a,b) => {
			return Math.random() < 0.5 ? -1 : 1 } },
	])

	const layoutOptions = $state([
		{ label: "As Graph", value: "graph", icon: "Graph"	  },
		{ label: "As Grid",  value: "grid",	 icon: "GridFour" },
		{ label: "As Table", value: "table", icon: "Table"	  }
	])

</script>



<!-- <pre>{JSON.stringify(
	[...new Set($page.props.activeProject?.data.items.map(i => i.type))].map(t => {
		return { label: t, value: t.toLowerCase(), filterFunction: i => i.type === t }
	}),
null,3)}</pre> -->


<ControlBar
	class={className}
	data={data.items}
	bind:query bind:filter bind:sort
	bind:results bind:size bind:layout
	filterOptions={filterOptions}
	sortOptions={sortOptions}
	layoutOptions={layoutOptions}
	onUpdate={onUpdate}
	{min} {max}
{...restProps} />