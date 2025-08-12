<script>
	import { route } from 'momentum-trail'

	import Grid from '@/Components/Core/Grid.svelte'
    import Card from '@/Components/UI/Card.svelte'

	let {
		factions,
		class: className,
		cols,
		...restProps
	} = $props()

</script>

<Grid
	cols={cols}
	gap={2}
{...restProps}>
	{#each factions as faction}
		<Card aspect="square"
			image={faction.emblem?.url}
			icon="FlagBannerFold"
			title={faction.name}
			subtitle="{faction.members.length} members"
			href={route('factions.show', {faction: faction.slug})}
		/>
	{/each}
</Grid>