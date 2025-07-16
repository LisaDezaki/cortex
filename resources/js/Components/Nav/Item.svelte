<script>
    import { Link } from '@inertiajs/svelte'
	import Badge from '@/Components/Badge.svelte'
	import Icon from '@/Components/Icon.svelte'

    let {
        active = false,
		badge,
		children,
		class: className,
		icon,
		label,
        ...attrs
    } = $props()
</script>

<li class="nav-item {active ? 'active' : ''}">

	<Link
		{...attrs}
		class="nav-link {className} {active ? 'active' : ''}"
	>
		{#if icon}
			<Icon name={icon} size={20} />
		{/if}

		{#if label}
			{label}
		{/if}

		{#if children}
			{@render children()}
		{/if}

		{#if badge}
			<Badge plain label={badge} class="ml-auto bg-white/10 text-white rounded" />
		{/if}
		
	</Link>
</li>

<style lang="postcss">

	:global(.nav-link) {
		@apply flex items-center gap-3 p-2;
	}

	.nav-item {
		@apply block rounded list-none;
		@apply font-medium text-sm leading-5;
		@apply transition duration-150 ease-in-out;
		&:hover {
			color: var(--text-white);
		}
	}

	.nav-item.active {
		@apply bg-emerald-600;
		@apply text-white;
		background-color: var(--bg-nav-link-hover);
		color: var(--text-nav-link-hover);
	}

</style>