<script>
	import { Link } from '@inertiajs/svelte'
	import Icon from '@/Components/Icon.svelte'
    let {
        children,
        class: className,
		icon,
		iconSize = 16,
		iconWeight = 'regular',
		label,
		loading,
        ...attrs
    } = $props()
</script>

{#if attrs.href}
	<Link {...attrs}
		class="{className}
		{attrs.plain ? '' : 'button font-style-button'}
		{attrs.primary ? 'primary' : ''}
		{attrs.secondary ? 'secondary' : ''}
		{attrs.special ? 'special' : ''}
		{attrs.danger ? 'danger' : ''}"
	>
		{#if icon}
			<Icon name={icon} size={iconSize} weight={iconWeight} />
		{/if}

		{#if label}
			{label}
		{/if}

		{#if children}
			{@render children()}
		{/if}

	</Link>
{:else}
	<button {...attrs}
		aria-disabled={attrs.disabled ? 'true' : undefined}
		type={attrs.type || 'button'}
		class="button {className}
			{attrs.plain ? '' : 'font-style-button'}
			{attrs.primary ? 'primary' : ''}
			{attrs.secondary ? 'secondary' : ''}
			{attrs.special ? 'special' : ''}
			{attrs.danger ? 'danger' : ''}"
	>
		{#if icon}
			<Icon name={icon} size={iconSize} weight={iconWeight} />
		{/if}

		{#if label}
			{label}
		{/if}

		{#if children}
			{@render children()}
		{/if}

	</button>
{/if}

<style lang="postcss">

	:global(.button) {
		@apply inline-flex items-center justify-center gap-2 flex-shrink-0 px-3 py-2;
		@apply transition duration-300 ease-in-out;
		@apply focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2;

		&.primary {
			@apply border rounded-md;
			background: var(--gradient-primary);
			border-color: var(--border-primary);
			color: var(--text-white);
			&:hover {
				background: var(--gradient-primary-alt);
			}
		}
		&.secondary {
			@apply border rounded-md;
			background: var(--gradient-secondary);
			border-color: var(--border-secondary);
			color: var(--text-body);
			&:hover {
				background: var(--gradient-secondary-alt);
			}
		}
		&.special {
			@apply border rounded-md;
			background: repeating-linear-gradient(
							-45deg,
							rgba(16, 185, 129, 0.15),
							rgba(16, 185, 129, 0.15) 10px,
							rgba(16, 185, 129, 0.1) 10px,
							rgba(16, 185, 129, 0.1) 20px
						);
			color: var(--text-accent);
			&:hover {
				background: repeating-linear-gradient(
							-45deg,
							rgba(16, 185, 129, 0.2),
							rgba(16, 185, 129, 0.2) 10px,
							rgba(16, 185, 129, 0.1) 10px,
							rgba(16, 185, 129, 0.1) 20px
						);
			}
		}

		&.danger {
			@apply border rounded-md;
			background: var(--gradient-danger);
			border-color: var(--border-danger);
			color: var(--text-white);
			&:hover {
				background: var(--gradient-danger-alt);
			}
		}
		&[aria-disabled] {
			@apply border rounded-md;
			@apply cursor-not-allowed;
			background: var(--bg-disabled);
			border-color: var(--border-disabled);
			color: var(--text-disabled);
		}
	}
	
</style>