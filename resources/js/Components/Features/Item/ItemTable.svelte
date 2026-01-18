<script>

	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import Flex          from '@/Components/Core/Flex.svelte'
	import Form          from '@/Components/Core/Form.svelte'
	import Inline        from '@/Components/Core/Inline.svelte'
	import Button        from '@/Components/UI/Button.svelte'
	import Icon          from '@/Components/UI/Icon.svelte'
	import Table         from '@/Components/UI/Table'
	import Thumbnail     from '@/Components/UI/Thumbnail.svelte'

	let customFields = $page.props.customFields?.data

    let {
		class: className,
		items = [],
		selected = [],
		selectionMode
	} = $props()

	let columns = $state(['name', 'type', 'cost', 'craftable', 'consumable', 'weaponable', 'wearable', 'weight', 'unique'])

	function selectAll() {
		// if (selected.length == characters.length) {
		// 	selected = []
		// } else {
		// 	characters.each(c => { selected.push(c.id)})
		// 	// selected = characters.map(c => c.id)
		// }
	}

	function selectRow(id) {
		if (selected.includes(id)) {
			let i = selected.indexOf(id)
			selected.splice(i,1)
		} else {
			selected.push(id)
		}
	}

</script>



{#snippet headRow()}
	{#if selectionMode}
		<Table.Head shrink><Form.Checkbox onclick={selectAll} /></Table.Head>
	{/if}
	<Table.Head sortable>Name</Table.Head>
	{#if columns.includes('type')}
		<Table.Head sortable>Type</Table.Head>
	{/if}
	<!-- {#if columns.includes('consumable')}
		<Table.Head sortable>Consumable</Table.Head>
	{/if}
	{#if columns.includes('craftable')}
		<Table.Head sortable>Craftable</Table.Head>
	{/if}
	{#if columns.includes('weaponable')}
		<Table.Head sortable>Weaponable</Table.Head>
	{/if}
	{#if columns.includes('wearable')}
		<Table.Head sortable>Wearable</Table.Head>
	{/if} -->
	{#if columns.includes('cost')}
		<Table.Head sortable class="max-w-24">Cost</Table.Head>
	{/if}
	{#if columns.includes('weight')}
		<Table.Head sortable class="max-w-24">Weight</Table.Head>
	{/if}
	{#if columns.includes('unique')}
		<Table.Head sortable class="max-w-24">Unique</Table.Head>
	{/if}
	{#each customFields as field}
		{#if columns.includes(field.name)}
			<Table.Head sortable>{field.label}</Table.Head>
		{/if}
	{/each}
{/snippet}

{#snippet bodyRow(item)}
	{#if selectionMode}
		<Table.Cell shrink>
			<Form.Checkbox checked={selected.includes(item.id)} onclick={() => selectRow(item.id)} />
		</Table.Cell>
	{/if}
	<Table.Cell>
		<Link class="flex items-center gap-1.5 py-0.5 hover:text-emerald-500" href={route('items.show', {item: item.slug})}>
			<Thumbnail
				class="bg-neutral-softest h-6 w-6 rounded"
				src={item.image?.url}
			/>
			<Inline>{item.name}</Inline>
		</Link>
	</Table.Cell>
	{#if columns.includes('type')}
		<Table.Cell class="flex items-center gap-1.5 py-0.5">
			<Inline>{item.type}</Inline>
		</Table.Cell>
	{/if}
	<!-- {#if columns.includes('consumable')}
		<Table.Cell class="flex items-center gap-1.5 py-0.5">
			<Inline>
				<Icon class={item.consumable ? "text-accent" : "text-danger"} name={item.consumable ? "CheckCircle" : "XCircle"} weight="fill" />
			</Inline>
		</Table.Cell>
	{/if}
	{#if columns.includes('craftable')}
		<Table.Cell class="flex items-center gap-1.5 py-0.5">
			<Inline>
				<Icon class={item.craftable ? "text-accent" : "text-danger"} name={item.craftable ? "CheckCircle" : "XCircle"} weight="fill" />
			</Inline>
		</Table.Cell>
	{/if}
	{#if columns.includes('weaponable')}
		<Table.Cell class="flex items-center gap-1.5 py-0.5">
			<Inline>
				<Icon class={item.weaponable ? "text-accent" : "text-danger"} name={item.weaponable ? "CheckCircle" : "XCircle"} weight="fill" />
			</Inline>
		</Table.Cell>
	{/if}
	{#if columns.includes('wearable')}
		<Table.Cell class="flex items-center gap-1.5 py-0.5">
			<Inline>
				<Icon class={item.wearable ? "text-accent" : "text-danger"} name={item.wearable ? "CheckCircle" : "XCircle"} weight="fill" />
			</Inline>
		</Table.Cell>
	{/if} -->
	{#if columns.includes('cost')}
		<Table.Cell class="flex items-center gap-1.5 py-0.5 max-w-24">
			<Inline><Icon name="Coins" size="xs" class="mr-1.5 text-neutral-soft" />{item.cost}</Inline>
		</Table.Cell>
	{/if}
	{#if columns.includes('weight')}
		<Table.Cell class="flex items-center gap-1.5 py-0.5 max-w-24">
			<Inline><Icon name="Feather" size="xs" class="mr-1.5 text-neutral-soft" />{item.weight}</Inline>
		</Table.Cell>
	{/if}
	{#if columns.includes('unique')}
		<Table.Cell class="flex items-center gap-1.5 py-0.5 max-w-24">
			<Inline>
				<Icon size="sm" class={item.unique ? "text-accent" : "text-danger"} name={item.unique ? "CheckCircle" : "XCircle"} weight="fill" />
				<!-- {#if item.unique}
					<Icon class="text-accent" name="CheckCircle" weight="fill" />
				{:else}
					<Icon class="text-danger" name="XCircle" weight="fill" />
				{/if} -->
			</Inline>
		</Table.Cell>
	{/if}

	{#each customFields as field}
		{#if columns.includes(field.name)}
			<Table.Cell>
				{item.customFieldValues.find(f => f.customFieldId === field.id).value}
			</Table.Cell>
		{/if}
	{/each}
{/snippet}

<Table
	class="w-full {className}"
	data={items}
	{headRow} {bodyRow}
/>