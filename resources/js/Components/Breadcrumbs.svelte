<script>
	import { Link } from '@inertiajs/svelte'
	import Icon from '@/Components/Icon.svelte'
    let {
		class: className,
		data,
        ...attrs
    } = $props()
</script>

<div class="breadcrumbs {className}" {...attrs}>
    {#each data as breadcrumb, i}

		{#if breadcrumb.href}
			<Link class="breadcrumb" href={breadcrumb.href}>{breadcrumb.title}</Link>
		{:else}
			<span class="breadcrumb">{breadcrumb.title}</span>
		{/if}

		{#if i < data.length-1}
			<span class="breadcrumb-separator">
				 <!-- <Icon name="ArrowRight" size={16} /> -->
				/
			</span>
		{/if}

	{/each}
</div>

<style lang="postcss">

	.breadcrumbs {
		@apply flex items-center justify-start gap-2 px-4 py-2 text-sm w-full;
		/* background-color: var(--surface); */

		:global(a) {
			color: var(--text-link);
		}

		:global(svg) {
			opacity: 0.25;
		}

		.breadcrumb-separator {
			opacity: 0.25;
		}
	}

	:global(.breadcrumb) {
		@apply px-1.5 py-1 rounded;
	}
	:global(a.breadcrumb) {
		@apply hover:bg-slate-300/50;
	}

</style>