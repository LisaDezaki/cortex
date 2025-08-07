<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Form from '@/Components/Form.svelte'

    let passwordInput
    let currentPasswordInput

    const form = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    })

    function updatePassword(e) {
        e.preventDefault()
        $form.put(route('password.update'), {
            preserveScroll: true,
            onSuccess: () => $form.reset(),
            onError: () => {
                if ($form.errors.password) {
                    $form.reset('password', 'password_confirmation')
                    passwordInput?.focus()
                }
                if ($form.errors.current_password) {
                    $form.reset('current_password')
                    currentPasswordInput?.focus()
                }
            },
        })
    }
</script>

<Form
	class="mt-6 space-y-2"
	onsubmit={updatePassword}
	submitLabel="Update password"
>
	<Form.Field>
		<Form.Label for="current_password" value="Current Password" />
		<Form.Input
			id="current_password"
			bind:this={currentPasswordInput}
			bind:value={$form.current_password}
			type="password"
			autocomplete="current-password"
		/>
		<Form.Error message={$form.errors.current_password} />
	</Form.Field>

	<Form.Field>
		<Form.Label for="password" value="New Password" />
		<Form.Input
			id="password"
			bind:this={passwordInput}
			bind:value={$form.password}
			type="password"
			autocomplete="new-password"
		/>
		<Form.Error message={$form.errors.password} />
	</Form.Field>

	<Form.Field>
		<Form.Label for="password_confirmation" value="Confirm Password" />
		<Form.Input
			id="password_confirmation"
			bind:value={$form.password_confirmation}
			type="password"
			autocomplete="new-password"
		/>
		<Form.Error message={$form.errors.password_confirmation} />
	</Form.Field>
</Form>