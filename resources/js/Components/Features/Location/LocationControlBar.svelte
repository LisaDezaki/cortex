<script>
	import { page } from '@inertiajs/svelte'


	//	Layout & Components

	import ControlBar from '@/Components/UI/ControlBar.svelte'


	//	Page & Component props

	const customFields = $page.props.customFields?.data

	let {
		data, project,
 		results = $bindable([]),
		query	= $bindable(''),
		filter	= $bindable(''),
		sort	= $bindable('name'),
		size	= $bindable(5),
		layout  = $bindable('grid'),
		...restProps
	} = $props()

	
	//	Default values

	const min	= $state(3)
	const max	= $state(7)

	let filterFunction	= $derived((ch)  => { return ch })
	let sortFunction	= $derived((a,b) => { return a.name < b.name ? -1 : 1})

	function onUpdate(type, option) {
		if (type === 'filter') 	{ filterFunction = option.filterFunction }
		if (type === 'sort') 	{ sortFunction 	 = option.sortFunction   }
		results = data.filter(query, filterFunction, sortFunction)
	}


	//	Submenu Options

	let parentLocationOptions = project?.locations?.filter(l => l.children?.length > 0).map(l => {
		return { label: l.name, value: `parent.${l.slug}`, imageIcon: 'MapPin', image: l.image?.url || '', filterFunction: (loc) => { return loc.parent?.slug == filter.split('.')[1] } }
	})

	let childLocationOptions = project?.locations?.filter(l => l.parent !== null).map(l => {
		return { label: l.name, value: `children.*.${l.slug}`, imageIcon: 'MapPin', image: l.image?.url || '', filterFunction: (loc) => { return loc.children?.map(i => i.slug).includes(filter.split('.')[2]) } }
	})

	let locationTypeOptions = project?.locations?.reduce((acc,item) => {
		return acc.includes(item.type) ? acc : [...acc, item.type]
	}, []).sort((a,b) => a<b ? -1:1).map(n => ({ label: n, value: n, filterFunction: l => l.type === n }))

	let customFieldOptions = (field) => {
		return field.options?.map(opt => {
			return { label: opt.label, value: `${field.name}.${opt.value}`, filterFunction: (ch) => { return ch.customFieldValues.find(f => f.field?.label === filter.name)?.value !== filter.value } }
		})
	}


	//	Menu Options

	// items.reduce((acc, item) => {
	// 	if (!acc.includes(item.type)) {
	// 		acc.push(item.type);
	// 	}
	// 	return acc;
	// }, []);

	const filterOptions = $state([
		{ label: 'All Locations', 	value: '', filterFunction: (ch) => { return ch } },
		{ 	separator: true },
		{ label: 'Parent location...',	options: parentLocationOptions },
		// { label: 'Child location...',	options: childLocationOptions },
		{ label: 'Type',				options: locationTypeOptions },
		{ 	separator: true, hideIf: !customFields || customFields.length === 0 },
		...customFields?.map(f => {
			return { label: `${f.label}...`, options: customFieldOptions(f) }
		})
	])
	const sortOptions = $state([
		{ label: "By name",			value: 'name',      sortFunction: (a,b) => { return a.name 				< b.name					? -1 : 1 } },
		{ label: "By type",			value: 'type',      sortFunction: (a,b) => { return a.type             	< b.type					? -1 : 1 } },
		...customFields?.map(f => {
			return { label: `By ${f.label.toLowerCase()}`, value: f.name }
		}),
		{ 	separator: true },
		{ label: "Date Created",	value: 'created_at', sortFunction: (a,b) => { return a.meta.createdAt		< b.meta.createdAt 			? -1 : 1 } },
		{ label: "Date Updated",	value: 'updated_at', sortFunction: (a,b) => { return a.meta.updatedAt		< b.meta.updatedAt 			? -1 : 1 } },
		{ label: "Randomly",		value: 'random',     sortFunction: (a,b) => { return Math.random()          < 0.5 						? -1 : 1 } },
	])
	const layoutOptions = $state([
		{ label: "As Maps",  		value: "map",		icon: "Compass"	 },
		{ label: "As Grid",   		value: "grid",		icon: "GridFour" },
		{ label: "As Table",  		value: "table",		icon: "Table"	 }
	])

</script>



<ControlBar
	data={data.items}
	bind:query bind:filter bind:sort
	bind:results bind:size bind:layout
	filterOptions={filterOptions}
	sortOptions={sortOptions}
	layoutOptions={layoutOptions}
	onUpdate={onUpdate}
	{min} {max}
{...restProps} />