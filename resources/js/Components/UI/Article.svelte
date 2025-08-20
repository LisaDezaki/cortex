<script>
	import Button  from '@/Components/UI/Button.svelte'
	import Container from '@/Components/UI/Container.svelte'
	import Heading from '@/Components/UI/Heading.svelte'

    let {
		actions,
        children,
		class: className,
		bodyclass,
		noscroll,
		title,
		size = "full",
		subtitle,
    } = $props()

</script>

<article class="article xl:px-24 lg:px-12 md:px-6 sm:px-3 {noscroll ? 'overflow-hidden' : 'overflow-y-auto'} {className}">
	{#if children}
		{@render children()}
	{:else}
		<p class="font-style-large text-center opacity-50">No content available.</p>
	{/if}
</article>

<style lang="postcss">
	.article {
		@apply relative h-full w-full space-y-3;
	}
</style>