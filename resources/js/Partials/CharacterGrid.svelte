<script>
    import Grid          from '@/Components/Core/Grid.svelte'
    import CharacterCard from '@/Components/Features/Character/CharacterCard.svelte'

	let {
		characters,
		children,
		class: className,
		cols,
		gridItem,
		// itemOptions,
		// showControls = false,
		// showItemControls = false,
		...restProps
	} = $props()

</script>





<Grid
	cols={cols}
	gap={2}
{...restProps}>

	{#if characters}
		{#each characters as character}
			{#if gridItem}
				{@render gridItem(character)}
			{:else}
				<CharacterCard {character} />
			{/if}
		{/each}
	{/if}
	
</Grid>