<script>
	import { Link } from '@inertiajs/svelte'
	import Icon from '@/Components/Icon.svelte'
    let {
        children,
        class: className,
		icon = null,
		iconSize = 20,
		iconWeight = 'regular',
		label,
		loading,
		style = 'plain',
		theme = 'neutral',
        ...restProps
    } = $props()

	let thisIcon = $derived(icon)

	let styles = {
		button: "button",
		label:  'button-label font-style-button',
		hard:   'button-hard border',
		soft:   'button-soft border',
		plain:  'button-plain',
	}
</script>

{#if restProps.href}
	<Link aria-disabled={restProps.disabled ? 'true' : undefined}
		class="{styles.button} button-{theme} {styles[style]} {className}"
	{...restProps}>

		{#if thisIcon}
			<Icon name={thisIcon} size={iconSize} weight={iconWeight} />
		{/if}

		{#if label}
			<span class={styles.label}>{label}</span>
		{/if}

		{@render children?.()}

	</Link>
{:else}
	<button aria-disabled={restProps.disabled ? 'true' : undefined}
		type={restProps.type || 'button'}
		class="{styles.button} button-{theme} {styles[style]} {className}"
	{...restProps}>

		{#if thisIcon}
			<Icon name={thisIcon} size={iconSize} weight={iconWeight} />
		{/if}

		{#if label}
			<span class={styles.label}>{label}</span>
		{/if}

		{@render children?.()}

	</button>
{/if}

<style lang="postcss">

	:global(.button) {
		@apply inline-flex items-center justify-center gap-1 flex-shrink-0 p-2;
		@apply transition duration-300 ease-in-out flex-shrink-0;
		&:focus {
			outline: 1px solid var(--border-accent);
			outline-offset: 1px;
		}
		/* @apply focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2; */

		&:not([class*="rounded-"]) {
			@apply rounded-md;
		}

		&.button-hard.button-accent {
			background: var(--bg-accent-gradient);
			border-color: var(--border-accent-strong);
			color: var(--text-white);
			&:hover {
				background: var(--bg-accent-gradient-alt);
			}
		}
		&.button-hard.button-neutral {
			background: var(--bg-neutral-gradient);
			border-color: var(--border-neutral-soft);
			color: var(--text-neutral);
			&:hover {
				background: var(--bg-neutral-gradient-alt);
			}
		}
		&.button-hard.button-danger {
			background: var(--bg-danger-gradient);
			border-color: var(--border-danger-strong);
			color: var(--text-white);
			&:hover {
				background: var(--bg-danger-gradient-alt);
			}
		}

		&.button-soft.button-accent {
			background-color: var(--bg-accent-softest);
			border-color: var(--border-accent-softest);
			color: var(--text-accent);
			&:hover {
				background-color: var(--bg-accent-softer);
			}
		}
		&.button-soft.button-neutral {
			background-color: var(--bg-neutral-softest);
			border-color: var(--border-neutral-softest);
			&:hover {
				background-color: var(--bg-neutral-softer);
			}
		}
		&.button-soft.button-danger {
			background-color: var(--bg-danger-softest);
			border-color: var(--border-danger-softest);
			color: var(--text-danger);
			&:hover {
				background-color: var(--bg-danger-softer);
			}
		}

		&.button-plain.button-accent {
			color: var(--text-accent);
			&:hover {
				background-color: var(--bg-accent-softest);
			}
		}
		&.button-plain.button-neutral {
			&:hover {
				background-color: var(--bg-neutral-softest);
			}
		}
		&.button-plain.button-danger {
			color: var(--text-danger);
			&:hover {
				background-color: var(--bg-danger-softest);
			}
		}
		
		&[aria-disabled] {
			cursor: not-allowed;
			opacity: 50%;
		}

		.button-label {
			@apply leading-6 px-1;
		}
	}
	
</style>