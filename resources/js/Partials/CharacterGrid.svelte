<script>
    import CardGrid from '@/Components/CardGrid.svelte'
    import CharacterCard from '@/Components/CharacterCard.svelte'

	let {
		characters,
		class: className,
		cols,
		showControls = false,
		showItemControls = false,
		...restProps
	} = $props()

</script>





<CardGrid
	items={characters}
	class="{cols ? `grid grid-cols-${cols}` : 'flex flex-wrap'} {className}"
{...restProps}>
	{#snippet card(character)}
		<CharacterCard {character} showControls={showItemControls} />
	{/snippet}
</CardGrid>