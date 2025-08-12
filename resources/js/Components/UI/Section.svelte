<script>

	import Heading from '@/Components/UI/Heading.svelte'

	let {
        children,
		class: className,
		title,
		subtitle,
		limitWidth = false,
    } = $props()

</script>


<section class="section w-full {limitWidth ? 'max-w-[60rem]' : 'max-w-full'} {className}">
	{#if title}
		<Heading is="h3" as="h5" class="mb-3"
			heading={title}
			subheading={subtitle}
		/>
	{/if}

	{@render children?.()}

</section>


<style lang="postcss">

	:global(.article-body > .section),
	:global(.article-body > .form > .section) {
		@apply xl:px-32 lg:px-24 md:px-16 sm:px-8 py-12;
	}

	.section:not(:first-of-type) {
		border-top: 1px solid var(--border-neutral-softest);
	}

</style>