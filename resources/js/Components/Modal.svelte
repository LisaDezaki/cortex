<script>
    import { onDestroy } from 'svelte'
    import Portal from 'svelte-portal'
    import Transition from 'svelte-transition'

    let {
        children,
		class: className,
        closeable = true,
        maxWidth = '2xl',
        onclose = () => {},
        show = false,
    } = $props()

    let maxWidthClass = $derived(
        {
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
                    {@render children()}
                </div>
            </Transition>
        </div>
    </Transition>
</Portal>

<style lang="postcss">

	.modal {
		@apply mb-6 transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:mx-auto sm:w-full dark:bg-gray-800;
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