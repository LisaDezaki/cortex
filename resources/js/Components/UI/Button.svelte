<script>
	
	import clsx from 'clsx'
	import { Link } from '@inertiajs/svelte'
	import Icon from '@/Components/UI/Icon.svelte'

    let {
        children,
        class: className,
		disabled,
		icon = null,
		iconSize = 20,
		iconWeight = 'regular',
		iconAfter = null,
		iconAfterSize = "xs",
		iconAfterWeight = "regular",
		label,
		loading,
		size  = "md",
		style = 'plain',
		theme = 'neutral',
		type,
        ...restProps
    } = $props()

	let thisIcon = $derived(icon)

	let sizes = children || label ? {
		none: "p-0",
		xs: "px-1 py-0.5",
		sm: "px-1.5 py-1",
		md: "px-2 py-1.5",
		lg: "px-3 py-2",
		xl: "px-4 py-3"
	} : {
		none: "p-0",
		xs: "p-0.5",
		sm: "p-1",
		md: "p-1.5",
		lg: "p-2",
		xl: "p-3"
	}

	const cx = $derived({
		button: clsx({
			'button inline-flex items-center justify-center gap-1 shrink-0 transition duration-300 ease-in-out': true,
			'border': style !== 'plain',
			'cursor-not-allowed opacity-50': disabled,
			
			'bg-accent-gradient border-accent-strong text-white hover:bg-accent-gradient-alt':  style === 'hard' && theme === 'accent',
			'bg-accent-softest border-accent-softest text-accent hover:bg-accent-softer': 		style === 'soft' && theme === 'accent',
			'text-accent hover:bg-accent-softest': style === 'plain' && theme === 'accent',

			'bg-neutral-gradient border-neutral-softest text-neutral hover:bg-neutral-gradient-alt': style === 'hard' && theme === 'neutral',
			'bg-neutral-softest border-neutral-softest text-neutral hover:bg-neutral-softer': 		 style === 'soft' && theme === 'neutral',

			'bg-danger-gradient border-danger-strong text-white hover:bg-danger-gradient-alt':  style === 'hard' && theme === 'danger',
			'bg-danger-softest border-danger-softest text-danger hover:bg-danger-softer': 		style === 'soft' && theme === 'danger',
			'text-danger hover:bg-danger-softest': style === 'plain' && theme === 'danger',
		}, className),
		label: clsx('button-label line-clamp-1 px-1 whitespace-pre')
	})

</script>



{#if restProps.href}
	<Link as={!restProps.href ? 'button' : 'a'} aria-disabled={restProps.disabled ? 'true' : undefined}
		class="{cx.button} {sizes[size]} {className}"
	{...restProps}>

		{@render contents()}

	</Link>
{:else}
	<button aria-disabled={restProps.disabled ? 'true' : undefined}
		type={restProps.type || 'button'}
		class="{cx.button} {sizes[size]} {className}"
	{...restProps}>

		{@render contents()}

	</button>
{/if}

{#snippet contents()}
	{#if loading}
		<Icon name="CircleNotch" animation="animate-[spin_0.5s_linear_infinite]" />

	{:else}

		{#if thisIcon}
			<Icon name={thisIcon} size={iconSize} weight={iconWeight} />
		{/if}

		{#if label}
			<span class={cx.label}>{label}</span>
		{/if}

		{@render children?.()}

		{#if iconAfter}
			<Icon class="text-neutral-softest" name="CaretDown" size="xs" weight="fill" />
		{/if}

	{/if}
{/snippet}