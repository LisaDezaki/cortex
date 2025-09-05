<script>
    import { Grid } from '@/Components/Core'
    import Empty from '@/Components/UI/Empty.svelte'
    import CharacterCard from '@/Components/Features/Character/CharacterCard.svelte'

	let {
		characters,
		class: className,
		cols,
		gridItem,
		...restProps
	} = $props()

</script>




{#if characters && characters.length > 0}

	<Grid
		class={className}
		cols={cols}
		gap={2}
	{...restProps}>
		{#each characters as character}
			{#if gridItem}
				{@render gridItem(character)}
			{:else}
				<CharacterCard {character} />
			{/if}
		{/each}
	</Grid>

{:else}

	<Empty
		message="There were no results."
	/>

{/if}