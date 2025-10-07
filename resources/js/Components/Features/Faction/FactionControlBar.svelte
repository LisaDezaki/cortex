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
		size	= $bindable(8),
		layout  = $bindable('grid'),
		...restProps
	} = $props()


	//	Default values

	const min	= $state(4)
	const max	= $state(12)

	let filterFunction	= $derived((ch)  => { return ch })
	let sortFunction	= $derived((a,b) => { return a.name < b.name ? -1 : 1})

	function onUpdate(type, option) {
		if (type === 'filter') 	{ filterFunction = option.filterFunction }
		if (type === 'sort') 	{ sortFunction 	 = option.sortFunction   }
		results = data.filter(query, filterFunction, sortFunction)
	}


	//	Submenu Options

	let locationOptions = project.locations?.items?.map(l => {
		return { label: l.name, value: `location.${l.slug}`,	imageIcon: 'MapPinArea', 	 image: l.image?.url || '', filterFunction: (fac) => { return fac.headquarters?.slug === l.slug } }
	})
	
	let characterOptions = project.characters?.items?.map(c => {
		return { label: c.name, value: `character.*.${c.slug}`, imageIcon: 'FlagBannerFold', image: c.image?.url || '', filterFunction: (fac) => { return fac.members?.map(m => m.slug).includes(filter.split('.')[2]) } }
	})

	let customFieldOptions = (field) => {
		return field.options?.map(opt => {
			return { label: opt.label, value: `${field.name}.${opt.value}`, filterFunction: (ch) => { return ch.customFieldValues.find(f => f.field?.label === filter.name)?.value !== filter.value } }
		})
	}

	//	Menu Options

	const filterOptions = $state([
		{ label: 'All Factions', 	value: '',		  filterFunction: (fac) => { return fac } },
		{ label: 'Starred', 		value: 'starred', filterFunction: (fac) => { return fac.starred } },
		{ 	separator: true },
		{ label: 'Headquarters...',	options: locationOptions },
		{ label: 'Member...',		options: characterOptions },
		{ 	separator: true, hideIf: !customFields || customFields.length === 0 },
		...customFields?.map(f => {
			return { label: `${f.label}...`, options: customFieldOptions(f) }
		}),
	])
	const sortOptions = $state([
		{ label: "By name",			value: 'name',       sortFunction: (a,b) => { return a.name 				 < b.name					? -1 : 1 } },
		{ label: "By type",			value: 'type',       sortFunction: (a,b) => { return a.type             	 < b.type					? -1 : 1 } },
		{ label: "By member count",	value: 'members',    sortFunction: (a,b) => { return a.members?.items.length > b.members?.items.length	? -1 : 1 } },
		...customFields?.map(f => {
			return { label: `By ${f.label.toLowerCase()}`, value: f.name }
		}),
		{ 	separator: true },
		{ label: "Date Created",	value: 'created_at', sortFunction: (a,b) => { return a.meta.createdAt		< b.meta.createdAt 			? -1 : 1 } },
		{ label: "Date Updated",	value: 'updated_at', sortFunction: (a,b) => { return a.meta.updatedAt		< b.meta.updatedAt 			? -1 : 1 } },
		{ label: "Randomly",		value: 'random',     sortFunction: (a,b) => { return Math.random()          < 0.5 						? -1 : 1 } },
	])
	const layoutOptions = $state([
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