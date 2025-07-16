<script>
    import { useForm } from '@inertiajs/svelte'
    import Modal from '@/Components/Modal.svelte'

	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form'

    import { route } from 'momentum-trail'

    let confirmingUserDeletion = $state(false)
    let passwordInput

    const form = useForm({
        password: '',
    })

    function closeModal() {
        confirmingUserDeletion = false
        $form.reset()
    }

    function confirmUserDeletion() {
        confirmingUserDeletion = true
        setTimeout(() => passwordInput?.focus(), 250)
    }

    function deleteUser() {
        $form.delete(route('profile.destroy'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput?.focus(),
            onFinish: () => $form.reset(),
        })
    }
</script>

<Button danger onclick={confirmUserDeletion}>Delete Account</Button>

<Modal show={confirmingUserDeletion} onclose={closeModal}>
	<Form class="p-6">
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
			<Button secondary onclick={closeModal}>Cancel</Button>

			<Button danger
				class="ms-3 {$form.processing && 'opacity-25'}"
				disabled={$form.processing}
				onclick={deleteUser}
			>
				Delete Account
			</Button>
		</div>
	</Form>
</Modal>