<script>
	import { onMount } from 'svelte'
	import { page } from '@inertiajs/svelte'


	//	Layout & Components

	import ControlBar from '@/Components/UI/ControlBar.svelte'


	//	Page & Component props

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

	let filterOption    = $derived(project.getOptions('characters', 'filter').find(opt => opt.value === filter) || '')
	let sortOption		= $derived(project.getOptions('characters',   'sort').find(opt => opt.value === sort)   || '')

	onMount(() => {
		filterOption    = project.getOptions('characters', 'filter').find(opt => opt.value === filter) || ''
		sortOption		= project.getOptions('characters',   'sort').find(opt => opt.value === sort  ) || ''
		results = data.filter(query, filterOption.filterFunction, sortOption.sortFunction)
	})

	function onUpdate(type, option) {
		if (type === 'filter') 	{ filterOption = option }
		if (type === 'sort') 	{ sortOption   = option }
		results = data.filter(query, filterOption.filterFunction, sortOption.sortFunction)
	}

</script>



<!-- <div class="h-screen overflow-y-auto">
	<pre>{JSON.stringify(project.getOptions('customFields', 'character'),null,2)}</pre>
</div> -->

<ControlBar
	class={className}
	data={data.items}
	bind:query bind:filter bind:sort
	bind:results bind:size bind:layout
	filterOptions={project.getOptions('characters', 'filter')}
	sortOptions={project.getOptions('characters', 'sort')}
	layoutOptions={project.getOptions('characters', 'layout')}
	onUpdate={onUpdate}
	{min} {max}
{...restProps} />