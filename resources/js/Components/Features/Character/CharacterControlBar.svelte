<script>
	import { page } from '@inertiajs/svelte'


	//	Layout & Components

	import ControlBar from '@/Components/UI/ControlBar.svelte'


	//	Page & Component props

	const customFields = $page.props.customFields?.data

	let {
		class: className,
		data, project,
		results = $bindable([]),
		query	= $bindable(''),
		filter	= $bindable(''),
		sort	= $bindable('name'),
		size	= $bindable(8),
		layout  = $bindable('grid'),
		...restProps
	} = $props()


	//	Default values

	const min	= $state(6)
	const max	= $state(11)

	let filterFunction	= $derived((ch)  => { return ch })
	let sortFunction	= $derived((a,b) => { return a.name < b.name ? -1 : 1})

	function onUpdate(type, option) {
		if (type === 'filter') 	{ filterFunction = option.filterFunction }
		if (type === 'sort') 	{ sortFunction 	 = option.sortFunction   }
		results = data.filter(query, filterFunction, sortFunction)
	}

	function customFilterFunction(ch) {
		// return ch.customFieldValues.find(cf => cf.field?.name === f.name)?.value === v
		return ch.customFieldValues.find(f => f.field?.name === filter.split('.')[0])?.value === filter.split('.')[1]
	}

	function customSortFunction(a,b,f) {
		return a.customFieldValues.find(v => v.field?.name === f.name)?.value < b.customFieldValues.find(v => v.field?.name === f.name)?.value ? -1 : 1
	}


	//	Submenu Options

	let factionOptions = project.factions?.items?.map(f => {
		return { label: f.name, value: `factions.*.${f.slug}`, 		imageIcon: 'FlagBannerFold',	image: f.image?.url || '', filterFunction: (ch) => { return ch.factions[0]?.slug == f.slug } }
	})

	let locationOptions = project.locations?.items?.map(l => {
		return { label: l.name, value: `location.${l.slug}`, 		imageIcon: 'MapPinArea',		image: l.image?.url || '', filterFunction: (ch) => { return ch.location?.slug == l.slug } }
	})

	let relationshipOptions = project.characters?.items?.map(c => {
		return { label: c.name, value: `relationship.*.${c.slug}`, 	imageIcon: 'User',			image: c.image?.url || '', filterFunction: (ch) => { return ch.relationships?.items?.map(r => r.slug).includes(filter.split('.')[2]) } }
	})

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
		{ label: 'All characters', 	value: '',		  	filterFunction: (ch) => { return ch } },
		{ label: 'Starred', 		value: 'starred', 	filterFunction: (ch) => { return ch.starred } },
		{ 	separator: true },
		{ label: 'Faction',			showImage: true, 	options: factionOptions },
		{ label: 'Location',		showImage: true, 	options: locationOptions },
		{ label: 'Relationship',	showImage: true, 	options: relationshipOptions },
		{ 	separator: true, hideIf: !customFields || customFields.length === 0 },
		...customFields?.map(f => {
			return { label: f.label, options: customFieldOptions(f) || [] }
		})
	])

	const sortOptions = $state([
		{ label: "By name", value: 'name', sortFunction: (a,b) => {
			return a.name < b.name ? -1 : 1 } },
		{ label: "By alias", value: 'alias', sortFunction: (a,b) => {
			return a.alias < b.alias ? -1 : 1 } },
		{ label: "By popularity", value: 'popularity', sortFunction: (a,b) => {
			return a.relationships?.items?.length > b.relationships?.items?.length 	? -1 : 1 } },
		{ label: "By location", value: 'location', sortFunction: (a,b) => {
			return (a.location?.name || '_') < (b.location?.name || '_') ? -1 : 1 } },
		{ label: "By faction", value: 'faction', sortFunction: (a,b) => {
			return (a.factions?.items?.[0]?.name || '_') < (b.factions?.items?.[0]?.name || '_') ? -1 : 1 } },
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