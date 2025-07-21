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
		style = 'plain',
		theme = 'neutral',
        ...attrs
    } = $props()

	let styles = {
		button: `button inline-flex items-center justify-center gap-1 flex-shrink-0 p-2.5 ${className}`,
		label:  'button-label font-style-button leading-6 px-1',
		hard:   'button-hard border rounded-md',
		soft:   'button-soft border rounded-md',
		plain:  'button-plain',
	}
</script>

<!-- <svelte:element this={attrs.href ? Link : 'button'}
	aria-disabled={attrs.disabled ? 'true' : undefined}
	class="{styles.button} button-{theme} {styles[style]}"
	type={attrs.type || 'button'}
{...attrs}>

	{#if icon}
		<Icon name={icon} size={iconSize} weight={iconWeight} />
	{/if}

	{#if label}
		<span class={styles.label}>{label}{@render children?.()}</span>
	{/if}

</svelte:element> -->

{#if attrs.href}
	<Link aria-disabled={attrs.disabled ? 'true' : undefined}
		class="{styles.button} button-{theme} {styles[style]}"
	{...attrs}>

		{#if icon}
			<Icon name={icon} size={iconSize} weight={iconWeight} />
		{/if}

		{#if label}
			<span class={styles.label}>{label}</span>
		{/if}

		{@render children?.()}

	</Link>
{:else}
	<button 
		aria-disabled={attrs.disabled ? 'true' : undefined}
		type={attrs.type || 'button'}
		class="{styles.button} button-{theme} {styles[style]}"
	{...attrs}>

		{#if icon}
			<Icon name={icon} size={iconSize} weight={iconWeight} />
		{/if}

		{#if label}
			<span class={styles.label}>{label}</span>
		{/if}

		{@render children?.()}

	</button>
{/if}

<style lang="postcss">

	:global(.button) {
		@apply transition duration-300 ease-in-out flex-shrink-0;
		@apply focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2;

		&.button-hard.button-accent {
			background: var(--gradient-primary);
			border-color: var(--border-primary);
			color: var(--text-white);
			&:hover {
				background: var(--gradient-primary-alt);
			}
		}
		&.button-hard.button-neutral {
			background: var(--gradient-secondary);
			border-color: var(--border-secondary);
			color: var(--text-body);
			&:hover {
				background: var(--gradient-secondary-alt);
			}
		}
		&.button-hard.button-danger {
			background: var(--gradient-danger);
			border-color: var(--border-danger);
			color: var(--text-white);
			&:hover {
				background: var(--gradient-danger-alt);
			}
		}

		&.button-soft.button-accent {
			background-color: var(--bg-accent-soft);
			border-color: var(--border-accent-soft);
			color: var(--text-accent);
			&:hover {
				background-color: var(--bg-accent-soft-hover);
			}
		}
		&.button-soft.button-neutral {
			background-color: var(--bg-neutral-soft);
			border-color: var(--border-neutral-soft);
			&:hover {
				background-color: var(--bg-neutral-soft-hover);
			}
		}
		&.button-soft.button-danger {
			background-color: var(--bg-danger-soft);
			border-color: var(--border-danger-soft);
			color: var(--text-danger);
			&:hover {
				background-color: var(--bg-danger-soft-hover);
			}
		}

		&.button-plain.button-accent {
			color: var(--text-accent);
			&:hover {
				background-color: var(--bg-accent-soft);
			}
		}
		&.button-plain.button-neutral {
			&:hover {
				background-color: var(--bg-neutral-soft);
			}
		}
		&.button-plain.button-danger {
			color: var(--text-danger);
			&:hover {
				background-color: var(--bg-danger-soft);
			}
		}

		/* &.primary {
			background: var(--gradient-primary);
			border-color: var(--border-primary);
			color: var(--text-white);
			&:hover {
				background: var(--gradient-primary-alt);
			}
		} */
		/* &.secondary {
			background: var(--gradient-secondary);
			border-color: var(--border-secondary);
			color: var(--text-body);
			&:hover {
				background: var(--gradient-secondary-alt);
			}
		}
		&.special {
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
		} */

		/* &.danger {
			background: var(--gradient-danger);
			border-color: var(--border-danger);
			color: var(--text-white);
			&:hover {
				background: var(--gradient-danger-alt);
			}
		} */
		&[aria-disabled] {
			cursor: not-allowed;
			opacity: 50%;
			/* background: var(--bg-disabled);
			border-color: var(--border-disabled);
			color: var(--text-disabled); */
		}
	}
	
</style>