<script>

	import Button from '@/Components/Button.svelte'

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
	{#if title}
		<header class="article-header">
			<h2 class="font-style-h6">{title}</h2>
			{#if subtitle}
				<p class="font-style-small opacity-65">{subtitle}</p>
			{/if}

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
		</header>
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
		@apply relative;
		background-color: var(--surface);
		box-shadow: inset  1px  1px  0 var(--shadow-highlight),
					inset -1px -1px  0 var(--shadow-lowlight);
	}

</style>