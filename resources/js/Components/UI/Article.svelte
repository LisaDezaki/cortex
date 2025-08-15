<script>
	import Button  from '@/Components/UI/Button.svelte'
	import Heading from '@/Components/UI/Heading.svelte'

    let {
		actions,
        children,
		class: className,
		bodyclass,
		title,
		subtitle,
    } = $props()

</script>

<article class="article {className}">
	<!-- {#if title}
		<Heading class="article-header" is="h2" as="h4"
			heading={title}
			subheading={subtitle}
		/>
	{/if} -->
	{#if actions}
		<div class="absolute top-6 right-6">
			{#each actions as action}
				<Button
					{...action}
					class="ml-2"
					iconSize={24}
				/>
			{/each}
		</div>
	{/if}
	{#if children}
		<div class="article-body {bodyclass}">
			{@render children()}
		</div>
	{:else}
		<p class="font-style-large text-center opacity-50">No content available.</p>
	{/if}
</article>

<style lang="postcss">

	.article {
		@apply relative h-full w-full overflow-hidden space-y-3;

		.article-body {
			@apply flex items-stretch justify-center h-full overflow-hidden;
		}
	}

</style>