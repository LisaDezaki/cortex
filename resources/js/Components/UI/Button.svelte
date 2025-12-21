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
		style = "plain",
		text,
		theme = "neutral",
		type = "button",
        ...restProps
    } = $props()

	let thisIcon = $derived(icon)

	const cx = $derived({
		button: clsx('button border-b inline-flex items-center justify-center shrink-0 transition duration-300 ease-in-out', `p-${size}`, {

			'cursor-not-allowed opacity-50': 	disabled,
			'rounded': 							!className?.includes('rounded-'),
			
			'bg-accent 				border-accent-strong 	text-white 	hover:bg-accent-gradient-alt':  	style === 'hard'  && theme === 'accent',
			'bg-accent-softest 		border-accent-softest 	text-accent hover:bg-accent-softer': 			style === 'soft'  && theme === 'accent',
			'bg-transparent 		border-transparent 		text-accent hover:bg-accent-softest': 			style === 'plain' && theme === 'accent',

			'bg-slate-50			border-neutral-softest 	text-neutral hover:bg-neutral-gradient-alt': 	style === 'hard'  && theme === 'neutral',
			'bg-neutral-softest		border-neutral-softest 	text-neutral hover:bg-neutral-softer': 			style === 'soft'  && theme === 'neutral',
			'bg-transparent			border-transparent 		text-neutral hover:bg-neutral-softest':			style === 'plain' && theme === 'neutral',

			'bg-danger-gradient 	border-danger-strong 	text-white 	hover:bg-danger-gradient-alt':  	style === 'hard'  && theme === 'danger',
			'bg-danger-softest 		border-danger-softest 	text-danger hover:bg-danger-softer': 			style === 'soft'  && theme === 'danger',
			'bg-transparent 		border-transparent 		text-danger hover:bg-danger-softest': 			style === 'plain' && theme === 'danger',

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