<!-- SCRIPT -->

<script>

	import { Link } from '@inertiajs/svelte'
	import Icon from '@/Components/Icon.svelte'

    let {
		children,
        class: className,
		icon,
		label,
        ...attrs
    } = $props()

</script>



<!-- STRUCTURE -->

<Link class="dropdown-link {className}" {...attrs}>

	{#if icon}
		<Icon name={icon} size={20} />
	{/if}

	{#if label}
		{label}
	{/if}

	{#if children}
		{@render children()}
	{/if}
	
</Link>



<!-- STYLE -->

<style lang="postcss">
	
	:global(.dropdown-link) {
		@apply flex items-center gap-3 min-h-11 px-2 py-1 w-full;
		@apply rounded;
		@apply text-sm leading-5;
		@apply transition duration-150 ease-in-out;
		@apply border-transparent;

		&:hover {
			background-color: var(--background);
		}
	}

</style>