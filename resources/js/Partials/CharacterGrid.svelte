<script>
    import Grid          from '@/Components/Core/Grid.svelte'
    import CharacterCard from '@/Components/Features/Character/CharacterCard.svelte'

	let {
		characters,
		children,
		class: className,
		cols,
		showControls = false,
		showItemControls = false,
		...restProps
	} = $props()

</script>





<Grid
	cols={cols}
	gap={2}
{...restProps}>
	{#each characters as character}
		<CharacterCard {character} />
	{/each}
</Grid>