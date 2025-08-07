<script>

	import Heading from '@/Components/Heading.svelte'

	let {
        children,
		class: className,
		title,
		subtitle,
		limitWidth = false,
    } = $props()

</script>


<section class="section xl:px-24 lg:px-16 md:px-8 sm:px-4 py-6 first-of-type:pt-9 w-full {limitWidth ? 'max-w-[60rem]' : 'max-w-full'} {className}">
	{#if title}
		<Heading is="h3" as="h5" class="mb-3"
			heading={title}
			subheading={subtitle}
		/>
	{/if}

	{@render children?.()}

</section>