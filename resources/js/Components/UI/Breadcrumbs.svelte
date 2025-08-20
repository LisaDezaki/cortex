<script>
	import { Link, page } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	const projects = $page.props.projects?.data
	const activeProject = $page.props.activeProject?.data

    let {
		class: className,
		data,
		withProject = true,
        ...restProps
    } = $props()

</script>





<style lang="postcss">

	.breadcrumbs {
		@apply flex items-center justify-start gap-2 px-1 py-1 text-sm w-full;

		:global(a),
		:global(.dropdown-trigger) {
			color: var(--text-accent);
		}
	}

	:global(.breadcrumb) {
		@apply px-1.5 py-1 rounded;
	}
	:global(a.breadcrumb),
	:global(.dropdown-trigger.breadcrumb) {
		&:hover {
			background-color: var(--bg-neutral-softest);
			color: var(--text-accent);
		}
	}

	:global(.breadcrumb-dropdown-link) {
		@apply px-1.5 py-1 rounded text-left w-full;
		&:hover {
			background-color: var(--bg-neutral-softest);
			color: var(--text-accent);
		}
	}
	:global(.breadcrumb-dropdown-link-active) {
		@apply font-semibold pointer-events-none;
		color: var(--text-accent);
	}

</style>






<div class="breadcrumbs {className}" {...restProps}>

	{#if withProject && activeProject && projects}
		<Link class="breadcrumb" href={route('dashboard')}>{activeProject.name}</Link>
		<span class="text-neutral-softer">/</span>
	{/if}

    {#each data as item, i}
		{#if i > 0}
			<span class="text-neutral-softer">/</span>
		{/if}
		{#if item.href}
			<Link class="breadcrumb" href={item.href}>{item.label}</Link>
		{:else}
			<span class="breadcrumb">{item.label}</span>
		{/if}
	{/each}

</div>