<script>
	//	Imports
	import { page } from '@inertiajs/svelte'
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
	let locationOptions = project.locations?.map(l => {
		return { label: l.name, value: `location.${l.slug}`,	imageIcon: 'MapPinArea', 	 image: l.image?.url || '', filterFunction: (ch) => { return ch.location.slug == l.slug } }
	})
	let characterOptions = project.characters?.map(c => {
		return { label: c.name, value: `character.*.${c.slug}`, imageIcon: 'FlagBannerFold', image: c.image?.url || '', filterFunction: (ch) => { return ch.relationships?.map(r => r.name).includes(filter.value) } }
	})
	let customFieldOptions = (field) => {
		return field.options?.map(opt => {
			return { label: opt.label, value: `${field.name}.${opt.value}`, filterFunction: (ch) => { return ch.customFieldValues.find(f => f.field?.label === filter.name)?.value !== filter.value } }
		})
	}

	//	Menu Options
	const filterOptions = $state([
		{ label: 'All Locations', 	value: '',		filterFunction: (lo) => { return lo } },
		{ 	separator: true },
		{ label: 'Headquarters...',	children: locationOptions },
		{ label: 'Member...',		children: characterOptions },
		{ 	separator: true },
		...customFields?.map(f => {
			return { label: `${f.label}...`, children: customFieldOptions(f) }
		}),
	])
	const sortOptions = $state([
		{ label: "By name",			value: 'name',       sortFunction: (a,b) => { return a.name 				< b.name					? -1 : 1 } },
		{ label: "By type",			value: 'type',       sortFunction: (a,b) => { return a.type             	< b.type					? -1 : 1 } },
		{ label: "By member count",	value: 'members',    sortFunction: (a,b) => { return a.members?.length      > b.members?.length 		? -1 : 1 } },
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
	bind:filteredData data={data}
	bind:query
	bind:filter filterOptions={filterOptions}
	bind:sort bind:sortDir sortOptions={sortOptions}
	bind:layout	layoutOptions={layoutOptions}
	bind:size	{min} {max}
{...restProps} />