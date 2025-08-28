<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Form } from '@/Components/Core'
	import Field from '@/Components/UI/Field.svelte'

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

<Form form={form}
	class="mt-6 space-y-2"
	onsubmit={updatePassword}
	submitLabel="Update password"
>
	<Field type="password"
		name="current_password"
		label="Current Password"
		errors={$form.errors.current_password}
		autocomplete="current-password"
	/>

	<Field type="password"
		name="password"
		label="New Password"
		errors={$form.errors.password}
		autocomplete="new-password"
	/>

	<Field type="password"
		name="password_confirmation"
		label="Confirm Password"
		autocomplete="new-password"
	/>
	
</Form>