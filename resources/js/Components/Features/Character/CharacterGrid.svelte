<script>
    import Grid          from '@/Components/Core/Grid.svelte'
    import CharacterCard from '@/Components/Features/Character/CharacterCard.svelte'

	let {
		characters,
		class: className,
		cols,
		gridItem,
		...restProps
	} = $props()

</script>





<Grid
	class={className}
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