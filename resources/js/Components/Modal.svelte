<script>
    import { onDestroy } from 'svelte'
    import Portal from 'svelte-portal'
    import Transition from 'svelte-transition'

	import Heading from '@/Components/Heading.svelte'

    let {
		actions,
        children,
		class: className,
        closeable = true,
        maxWidth = 'none',
        onclose = () => {},
		title,
        show = false,
    } = $props()

    let maxWidthClass = $derived(
        {
			none: 'sm:max-w-none',
            sm: 'sm:max-w-sm',
            md: 'sm:max-w-md',
            lg: 'sm:max-w-lg',
            xl: 'sm:max-w-xl',
            '2xl': 'sm:max-w-2xl',
        }[maxWidth],
    )

    $effect(() => {
        document.body.style.overflow = show ? 'hidden' : 'visible'
    })

    onDestroy(() => (document.body.style.overflow = 'visible'))

    function close() {
        if (closeable) {
            onclose()
        }
    }

    function closeOnEscape(e) {
        if (e.key === 'Escape' && show) {
            onclose()
        }
    }
</script>

<svelte:window on:keydown={closeOnEscape} />

<!-- svelte-ignore a11y_click_events_have_key_events -->
<Portal target="body">
    <Transition {show} leave="duration-200">
        <div class="fixed inset-0 z-50 flex flex-col justify-center overflow-y-auto px-4 py-6 sm:px-0" scroll-region>
            <Transition
                enter="ease-out duration-300"
                enterFrom="opacity-0"
                enterTo="opacity-100"
                leave="ease-in duration-200"
                leaveFrom="opacity-100"
                leaveTo="opacity-0"
            >
                <!-- svelte-ignore a11y_no_static_element_interactions -->
                <div class="overlay-wrap" onclick={close}>
                    <div class="overlay"></div>
                </div>
            </Transition>

            <Transition
                enter="ease-out duration-300"
                enterFrom="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                enterTo="opacity-100 translate-y-0 sm:scale-100"
                leave="ease-in duration-200"
                leaveFrom="opacity-100 translate-y-0 sm:scale-100"
                leaveTo="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
                <div class="modal {maxWidthClass} {className}">
					{#if title}
						<div class="modal-head">
							<Heading heading={title} />
						</div>
					{/if}
					<div class="modal-body">
						{@render children()}
					</div>
					{#if actions}
						<div class="modal-foot">
							{@render actions()}
						</div>
					{/if}
                </div>
            </Transition>
        </div>
    </Transition>
</Portal>

<style lang="postcss">

	.modal {
		@apply mb-6 transform overflow-y-auto rounded-lg shadow-xl transition-all sm:mx-auto dark:bg-gray-800;
		@apply flex flex-col items-stretch overflow-hidden;
		background-color: var(--bg-modal);
		color: var(--text-neutral);
		font-family: Archivo, Figtree, ui-sans-serif, system-ui, sans-serif;

		.modal-head {
			@apply flex-shrink-0 border-b;
			@apply px-6 py-3 z-10;
			background-color: var(--surface);
		}

		.modal-body {
			@apply flex-grow overflow-y-hidden;
		}

		.modal-foot {
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