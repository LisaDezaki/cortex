<script>
	import Button  from '@/Components/UI/Button.svelte'
	import Container from '@/Components/UI/Container.svelte'
	import Heading from '@/Components/UI/Heading.svelte'

    let {
		actions,
        children,
		class: className,
		bodyclass,
		title,
		size = "5xl",
		subtitle,
    } = $props()

</script>

<article class="article {className}">
	{#if children}
		<Container {size} class="article-body {bodyclass}">
			{@render children()}
		</Container>
	{:else}
		<p class="font-style-large text-center opacity-50">No content available.</p>
	{/if}
</article>

<style lang="postcss">

	.article {
		@apply relative h-full w-full overflow-hidden space-y-3;

		:global(.article-body) {
			@apply flex items-stretch justify-center h-full overflow-hidden w-full;
		}
	}

</style>