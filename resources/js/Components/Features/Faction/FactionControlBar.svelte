<script>
	import ControlBar from '@/Components/UI/ControlBar.svelte'

	let {
		data = $bindable(),
		onUpdate,
		...restProps
	} = $props()

	const handleUpdate = (query,filter,sort,layout) => {
		let filteredList = data
			.filter(c => {
				if (query.length > 0 && !c.name.toLowerCase().includes(query.toLowerCase())) { return false }
				if (filter === 'faction' && c.factions[0]?.name !== filter.value) { return false }
				if (filter === 'location' && c.location?.name !== filter.value) { return false }
				if (filter === 'relationship' && !c.relationships?.map(r => r.name).includes(filter.value)) { return false }
				if (!['Faction', 'Location', 'Relationship'].includes(filter.name) && filter.value && c.customFieldValues?.find(f => f.field?.label === filter.name)?.value !== filter.value) { return false }
				return true
			}).sort((a, b) => {
				if (sort === 'name')       { return a.name                 < b.name                 ? -1 : 1 }
				if (sort === 'alias')      { return a.alias                < b.alias                ? -1 : 1 }
				if (sort === 'popularity') { return a.relationships.length > b.relationships.length ? -1 : 1 }
				if (sort === 'faction')    { return a.factions?.[0]?.name  < b.factions?.[0]?.name  ? -1 : 1 }
				if (sort === 'location')   { return a.location?.name       < b.location?.name       ? -1 : 1 }
				if (sort === 'created_at') { return a.meta.createdAt       < b.meta.createdAt       ? -1 : 1 }
				if (sort === 'updated_at') { return a.meta.updatedAt       < b.meta.updatedAt       ? -1 : 1 }
				if (sort === 'random')     { return Math.random()          < 0.5                    ? -1 : 1 }
			})

		onUpdate(filteredList, {query,filter,sort,layout})
	}

</script>



<ControlBar
	bind:data
	filterOptions={[
		{ label: 'All Factions',	value: '' },
		{ label: 'Nameless',   		value: 'noname' },
		{ label: 'Incomplete', 		value: 'incomplete' },
		{ separator: true },
		{ label: 'Headquarters at...', children: data.locations?.map(l => {
			return { label: l.name, value: `location.${l.slug}`, image: l.banner?.url }
		}) },
		{ label: 'Has member...', children: data.character?.map(c => {
			return { label: c.name, value: `character.${c.slug}`, image: c.portrait?.url }
		}) },
		// ...customFields.filter(f => f.type == 'select').map(f => {
		// 	return { label: `${f.label}...`, children: f.options.map(o => {
		// 		return { label: o.label, value: `${f.name}.${o.value}` }
		// 	})}
		// })
	]}
	sortOptions={[
		{ value: 'name',         label: "By name" },
		{ value: 'members',      label: "By member count" },
		{ separator: true },
		{ value: 'created-at',   label: "Date Created" },
		{ value: 'updated-at',   label: "Date Updated" },
		{ value: 'random',       label: "Randomly" },
	]}
	layoutOptions={[
		{ icon: "GridFour", label: "As Grid",   value: "grid"  },
		{ icon: "Table",    label: "As Table",  value: "table" }
	]}
	onUpdate={handleUpdate}
{...restProps} />