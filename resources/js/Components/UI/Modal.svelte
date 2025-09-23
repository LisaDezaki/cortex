<script>
    import { onDestroy } from 'svelte'
    import Portal from 'svelte-portal'
    import Transition from 'svelte-transition'

	import { modalActions } from '@/stores/modalStore';
	

    import { Flex, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Heading from '@/Components/UI/Heading.svelte'

    let {
		actions,
        children,
		class: className,
        closeable = true,
		footer,
        maxWidth = 'none',
		title,
    } = $props()

    let maxWidthClass = $derived(
        {
			'none': 'sm:max-w-none',
            'sm':   'sm:max-w-sm',
            'md':   'sm:max-w-md',
            'lg':   'sm:max-w-lg',
            'xl':   'sm:max-w-xl',
            '2xl':  'sm:max-w-2xl',
        }[maxWidth],
    )

    // $effect(() => {
    //     document.body.style.overflow = show ? 'hidden' : 'visible'
    // })

    onDestroy(() => (document.body.style.overflow = 'visible'))

    function close() {
        if (closeable) {
			modalActions.close()
        }
    }

    function closeOnEscape(e) {
        if (e.key === 'Escape') {
			modalActions.close()
        }
    }
</script>

<svelte:window on:keydown={closeOnEscape} />





<!-- svelte-ignore a11y_click_events_have_key_events -->
<Portal target="body">
    <!-- <Transition {show} leave="duration-200"> -->
        <Stack justify="center" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0" scroll-region>
            <!-- <Transition
                enter="ease-out duration-300"
                enterFrom="opacity-0"
                enterTo="opacity-100"
                leave="ease-in duration-200"
                leaveFrom="opacity-100"
                leaveTo="opacity-0"
            > -->
                <!-- svelte-ignore a11y_no_static_element_interactions -->
                <div class="overlay-wrap" onclick={modalActions.close}>
                    <div class="overlay"></div>
                </div>
            <!-- </Transition> -->

            <!-- <Transition
                enter="ease-out duration-300"
                enterFrom="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                enterTo="opacity-100 translate-y-0 sm:scale-100"
                leave="ease-in duration-200"
                leaveFrom="opacity-100 translate-y-0 sm:scale-100"
                leaveTo="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            > -->
                <div class="modal {maxWidthClass} {className}">
					{#if title}
						<Flex justify="between" class="modal-head">
							<Heading is="h3" as="h6" heading={title} />
							<Flex gap={3}>
								<Button style="plain" theme="danger" class="rounded-full"
									icon="X" onclick={modalActions.close}
								/>
								<!-- <Button style="soft" theme="accent" class="rounded-full"
									icon="Check"
								/> -->
							</Flex>
						</Flex>
					{/if}
					<div class="modal-body">
						{@render children()}
					</div>
					{#if actions}
						<div class="modal-foot">
							{@render actions()}
						</div>
					{/if}
					{#if footer}
						<!-- <Flex align="center" justify="start" class="modal-foot">
							{@render footer?.()}
						</Flex> -->
					{/if}
                </div>
            <!-- </Transition> -->
        </Stack>
    <!-- </Transition> -->
</Portal>

<style lang="postcss">

	.modal {
		@apply max-h-full mb-6 rounded-lg transform shadow-xl transition-all sm:mx-auto overflow-hidden;
		@apply flex flex-col items-stretch w-full;
		background-color: var(--bg-modal);
		color: var(--text-neutral);
		font-family: Archivo, Figtree, ui-sans-serif, system-ui, sans-serif;

		:global(.modal-head) {
			@apply sticky top-0 flex-shrink-0 border-b;
			@apply p-2 pl-4 z-10;
			background-color: var(--surface);
		}

		.modal-body {
			@apply flex-grow overflow-y-auto;
		}

		:global(.modal-foot) {
			@apply flex-shrink-0 border-t;
			@apply border-t flex items-center justify-center gap-3 p-3;
		}
	}

	.overlay-wrap {
		@apply fixed inset-0 transform transition-all;
		animation: blur-in 500ms forwards;

		.overlay {
			@apply absolute inset-0 bg-black/40;
			animation: blur-in 500ms forwards;
		}
	}

	/* Let's define an animation: */
	@keyframes blur-in {
		from {
			backdrop-filter: blur(0px);
		}
		to {
			backdrop-filter: blur(2px);
		}
	}

</style>