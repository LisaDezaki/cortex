<script>
	import { route } from 'momentum-trail'

	import { Flex }  from '@/Components/Core'
	import Card  from '@/Components/UI/Card.svelte'
	import Icon  from '@/Components/UI/Icon.svelte'
	import Media  from '@/Components/UI/Media.svelte'

    let {
		class: className,
		collection,
		href,
		icon,
		onclick,
		options,
        ...restProps
    } = $props()

	const handleClick = (e) => {
		if (onclick) {
			e.preventDefault()
			onclick(e, collection)
		}
	}
</script>

<Card
	aspect="square"
	icon="FolderSimple"
	image={collection.image}
	imageClass="grid grid-cols-2 gap-1.5 p-1.5"
	title={collection.name}
	subtitle="{collection.items.length} items"
	onclick={handleClick || null}
	href={onclick ? null : route('collections.show', {collection: collection.slug})}
	options={options}
{...restProps}>

	{#if collection.items?.length > 0}
		{#each collection.items.filter((c,i) => {
			return i < 4
		}) as item }

			<Flex align="center" justify="center" class="aspect-square bg-neutral-softest border border-neutral-softest col-span-1 rounded text-neutral-soft w-full">
				{#if item.item?.image}
					<Media media={item.item?.image} />
				{:else if icon}
					<Icon name={icon} />
				{/if}
			</Flex>

		{/each}
	{:else}
		
		<Flex align="center" justify="center" class="col-span-2 row-span-2 font-style-placeholder">Empty</Flex>

	{/if}
	
</Card>