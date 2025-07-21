<script>

	import { Link, page } from '@inertiajs/svelte'

	import Icon from '@/Components/Icon.svelte'
	import Thumbnail from '@/Components/Thumbnail.svelte'

    let {
		class: className,
		data,
        ...attrs
    } = $props()

	let user = $page.props.auth.user
	let project = $page.props.active_project.data

</script>

<div class="breadcrumbs {className}" {...attrs}>

	{#if user}
		<Thumbnail class="rounded-full w-9" src={user.avatar} alt={user.name} />
		<Link class="breadcrumb" href="#">{user.name}</Link>
	{/if}

	{#if project}
		<Icon name="CaretRight" size={16} />
		<Link class="breadcrumb" href="#">{project.name}</Link>
	{/if}

    {#each data as breadcrumb, i}
		
		<Icon name="CaretRight" size={16} />

		{#if breadcrumb.href}
			<Link class="breadcrumb" href={breadcrumb.href}>{breadcrumb.title}</Link>
		{:else}
			<span class="breadcrumb">{breadcrumb.title}</span>
		{/if}

	{/each}
</div>



<style lang="postcss">

	.breadcrumbs {
		@apply flex items-center justify-start gap-2 px-4 py-2 text-sm w-full;

		:global(a) {
			color: var(--text-link);
		}

		:global(svg) {
			opacity: 0.25;
		}

		/* .breadcrumb-separator {
			opacity: 0.25;
		} */
	}

	:global(.breadcrumb) {
		@apply px-1.5 py-1 rounded;
	}
	:global(a.breadcrumb) {
		&:hover {
			background-color: var(--bg-neutral-soft);
		}
	}

</style>