<script>
	import { route } from 'momentum-trail'

    import Card from '@/Components/Card.svelte'
    import CardGrid from '@/Components/CardGrid.svelte'

	let {
		factions,
		class: className,
		cols,
		...restProps
	} = $props()

</script>

<CardGrid items={factions} class={className} {...restProps}>
	{#snippet card(faction)}
		<Card
			class="aspect-square w-full {cols ? `grid grid-cols-${cols}` : 'flex flex-wrap'} {className}"
			image={faction.emblem?.url}
			icon="FlagBannerFold"
			title={faction.name}
			subtitle="{faction.members.length} members"
			href={route('factions.show', {faction: faction.slug})}
		/>
	{/snippet}
</CardGrid>