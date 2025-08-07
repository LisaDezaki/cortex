<script>
    import { useForm } from '@inertiajs/svelte'

	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form.svelte'

    import { route } from 'momentum-trail'

	let {
		class: className,
		oncancel = () => {},
		...restProps
	} = $props()

    let passwordInput

    const form = useForm({
        password: '',
    })

    function deleteUser() {
        $form.delete(route('profile.destroy'), {
            preserveScroll: true,
            onSuccess: () => oncancel(),
            onError: () => passwordInput?.focus(),
            onFinish: () => $form.reset(),
        })
    }
</script>

<Form class="p-6" {...restProps}>
	<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
		Are you sure you want to delete your account?
	</h2>

	<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
		Once your account is deleted, all of its resources and data will be permanently deleted. Please enter
		your password to confirm you would like to permanently delete your account.
	</p>

	<div class="mt-6">
		<Form.Label for="password" value="Password" class="sr-only" />

		<Form.Input
			id="password"
			bind:this={passwordInput}
			bind:value={$form.password}
			type="password"
			class="mt-1 block w-3/4"
			placeholder="Password"
			onkeyup={(e) => e.key === 'Enter' && deleteUser()}
		/>

		<Form.Error message={$form.errors.password} class="mt-2" />
	</div>

	<div class="mt-6 flex justify-end">
		<Button secondary onclick={oncancel}>Cancel</Button>

		<Button danger
			class="ms-3 {$form.processing && 'opacity-25'}"
			disabled={$form.processing}
			onclick={deleteUser}
		>
			Delete Account
		</Button>
	</div>
</Form>