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
		loading,
		size = "md",
		style,
		text,
		theme,
		type = "button",
        ...restProps
    } = $props()

	let thisIcon = $derived(icon)

	const cx = $derived({
		button: clsx('button inline-flex items-center justify-center shrink-0 transition duration-300 ease-in-out', `p-${size}`, {

			'cursor-not-allowed opacity-50': 	disabled,
			'rounded': 							!className?.includes('rounded-'),
			
			'bg-accent 				shadow-accent-strong 	text-white 	hover:bg-accent-alt':  				style === 'hard'  && theme === 'accent',
			'bg-accent-softest 		shadow-accent-softest 	text-accent hover:bg-accent-softer': 			style === 'soft'  && theme === 'accent',
			'bg-transparent 		shadow-transparent 		text-accent hover:bg-accent-softest': 			style === 'plain' && theme === 'accent',

			'bg-slate-50			shadow-neutral-softest 	text-neutral hover:bg-neutral-gradient-alt': 	style === 'hard'  && theme === 'neutral',
			'bg-neutral-softest		shadow-neutral-softest 	text-neutral hover:bg-neutral-softer': 			style === 'soft'  && theme === 'neutral',
			'bg-transparent			shadow-transparent 		text-neutral hover:bg-neutral-softest':			style === 'plain' && theme === 'neutral',

			'bg-danger-gradient 	shadow-danger-strong 	text-white 	hover:bg-danger-gradient-alt':  	style === 'hard'  && theme === 'danger',
			'bg-danger-softest 		shadow-danger-softest 	text-danger hover:bg-danger-softer': 			style === 'soft'  && theme === 'danger',
			'bg-transparent 		shadow-transparent 		text-danger hover:bg-danger-softest': 			style === 'plain' && theme === 'danger',

		}, className),
		text: clsx('button-text line-clamp-1 whitespace-pre', `px-${size}`)
	})

</script>



{#if restProps.href}
	<Link as={!restProps.href ? 'button' : 'a'} aria-disabled={restProps.disabled ? 'true' : undefined}
		class={cx.button}
	{...restProps}>

		{@render contents()}

	</Link>
{:else}
	<button aria-disabled={restProps.disabled ? 'true' : undefined}
		type={restProps.type || 'button'}
		class={cx.button}
	{...restProps}>

		{@render contents()}

	</button>
{/if}

{#snippet contents()}
	{#if loading}
		<Icon name="CircleNotch" animation="animate-[spin_0.5s_linear_infinite]" />

	{:else}

		{#if thisIcon}
			<Icon name={thisIcon} size={size} weight={iconWeight} />
		{/if}

		{#if text}
			<span class={cx.text}>{text}</span>
		{/if}

		{@render children?.()}

		{#if iconAfter}
			<Icon class="text-neutral-softest" name="CaretDown" size="xs" weight="fill" />
		{/if}

	{/if}
{/snippet}