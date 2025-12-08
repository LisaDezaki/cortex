<script>

    import { onDestroy } from 'svelte'
    import Portal from 'svelte-portal'
	import { modalActions } from '@/stores/modalStore';
    import { Flex, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Heading from '@/Components/UI/Heading.svelte'
    import clsx from 'clsx'

    let {
		actions,
        children,
		class: className,
        maxWidth = 'none',
		title,
    } = $props()

	/**
	 * MaxWidth Class
	 * @type {Object}
	 */
    let maxWidthClass = $derived({
		'none': 'sm:max-w-none',
		'sm':   'sm:max-w-sm',
		'md':   'sm:max-w-md',
		'lg':   'sm:max-w-lg',
		'xl':   'sm:max-w-xl',
		'2xl':  'sm:max-w-2xl',
		'3xl':  'sm:max-w-3xl',
		'4xl':  'sm:max-w-4xl',
		'5xl':  'sm:max-w-5xl'
	}[maxWidth])

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		portal:  clsx('fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0'),
		wrap:    clsx('fixed inset-0 transform transition-all animate-[blur-in_500ms_forwards]'),
		overlay: clsx('absolute inset-0 bg-black/40 animate-[blur-in_500ms_forwards]'),
		modal:   clsx('modal flex flex-col items-stretch bg-surface font-body max-h-full mb-6 overflow-hidden rounded-lg transform shadow-xl text-neutral transition-all sm:mx-auto w-full', maxWidthClass, className),
		head:    clsx('modal-head sticky top-0 shrink-0 p-2 pl-4 z-10', 'bg-surface'),
		body:	 clsx('modal-body grow overflow-y-auto'),
		foot:	 clsx('modal-foot border-t flex items-center justify-center gap-3 p-3 shrink-0'),
	})

    onDestroy(() => (document.body.style.overflow = 'visible'))

    function closeOnEscape(e) {
        if (e.key === 'Escape') {
			modalActions.close()
        }
    }
</script>



<svelte:window on:keydown={closeOnEscape} />

<!-- svelte-ignore a11y_click_events_have_key_events -->
<Portal target="body">
	<Stack class={cx.portal} justify="center" scroll-region>

		<!-- svelte-ignore a11y_no_static_element_interactions -->
		<div class={cx.wrap} onclick={modalActions.close}>
			<div class={cx.overlay}></div>
		</div>
		
		<div class={cx.modal}>
			{#if title}
				<Flex justify="between" class={cx.head}>
					<Heading is="h3" as="h6" heading={title} />
					<Button style="plain" theme="danger" class="rounded-full"
						icon="X" onclick={modalActions.close}
					/>
				</Flex>
			{/if}
			<div class={cx.body}>
				{@render children()}
			</div>
			{#if actions}
				<Stack class={cx.foot}>
					{@render actions()}
				</Stack>
			{/if}
		</div>
	</Stack>
</Portal>