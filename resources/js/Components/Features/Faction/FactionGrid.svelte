<script>
	import Grid from '@/Components/Core/Grid.svelte'
	import FactionCard from '@/Components/Features/Faction/FactionCard.svelte'

	let {
		factions,
		class: className,
		cols,
		gridItem,
		...restProps
	} = $props()

</script>



{#if factions && factions.length > 0}

	<Grid
		class="w-full {className}"
		cols={cols}
		gap={2}
	{...restProps}>
		{#each factions as faction}
			{#if gridItem}
				{@render gridItem(faction)}
			{:else}
				<FactionCard {faction} />
			{/if}
		{/each}
	</Grid>

{:else}

	<Empty
		message="There were no results."
	/>

{/if}

<!-- <Grid
	cols={cols}
	gap={2}
{...restProps}>
	{#each factions as faction}
		<FactionCard aspect="square"
			image={faction.emblem?.url}
			icon="FlagBannerFold"
			title={faction.name}
			subtitle="{faction.members.length} members"
			href={route('factions.show', {faction: faction.slug})}
		/>
	{/each}
</Grid> -->