<script>
	import { inertia, page } from '@inertiajs/svelte'

	const user = $page.props.auth.user
    let {
		actions,
		children,
		class: className,
		mustVerifyEmail,
        onsubmit,
		processing,
		recentlySuccessful,
		status,
		submitLabel,
		title,
        ...attrs
    } = $props()

</script>

<form class="form {className}" {onsubmit} {...attrs}>

	{#if title}
		<span class="form-title font-style-h5">{title}</span>
	{/if}

	{@render children()}

	{#if mustVerifyEmail && user.email_verified_at === null}
		<p class="mt-2 text-sm text-gray-800 dark:text-gray-200">
			Your email address is unverified.
			<button
				use:inertia={{ href: route('verification.send'), method: 'post' }}
				class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
			>
				Click here to re-send the verification email.
			</button>
		</p>

		{#if status === 'verification-link-sent'}
			<div class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
				A new verification link has been sent to your email address.
			</div>
		{/if}
	{/if}

	{#if actions}
		<div class="flex items-center justify-center gap-4 mt-4 col-span-full">
			{@render actions()}
		</div>
	{/if}

	<!-- <div class="flex items-center gap-4">
		<Button type="submit" primary disabled={processing}>{submitLabel || "Submit"}</Button>

		<Transition
			show={recentlySuccessful}
			enter="transition ease-in-out"
			enterFrom="opacity-0"
			leave="transition ease-in-out"
			leaveFrom="opacity-0"
		>
			<p class="text-sm text-gray-600 transition ease-in-out dark:text-gray-400">Saved.</p>
		</Transition>
	</div> -->

</form>

<style lang="postcss">

	.form {
		@apply w-full;
	}

	.form-styles {
		@apply border p-6 rounded-lg;
		background-color: var(--bg-white);
	}

	.form-highlight {
		@apply rounded-lg;
		background: repeating-linear-gradient(
						-45deg,
						rgba(16, 185, 129, 0.15),
						rgba(16, 185, 129, 0.15) 10px,
						rgba(16, 185, 129, 0.05) 10px,
						rgba(16, 185, 129, 0.05) 20px
					);
	}

	.form-title {
		@apply text-slate-400 mb-2 col-span-full w-full;
	}

</style>