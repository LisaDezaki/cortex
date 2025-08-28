<script>
    import { useForm } from '@inertiajs/svelte'

	import { Form }   from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field from '@/Components/UI/Field.svelte'

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

<Form form={form}
	class="max-w-lg p-6"
{...restProps}>
	<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
		Are you sure you want to delete your account?
	</h2>

	<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
		Once your account is deleted, all of its resources and data will be permanently deleted. Please enter
		your password to confirm you would like to permanently delete your account.
	</p>

	<Field type="password" class="mt-4"
		name="password"
		label="Password" labelSrOnly
		errors={$form.errors.password}
		onkeyup={(e) => e.key === 'Enter' && deleteUser()}
		required
	/>

	<div class="mt-6 flex justify-end">
		<Button style="hard" theme="neutral" onclick={oncancel}>Cancel</Button>

		<Button style="hard" theme="danger"
			class="ms-3 {$form.processing && 'opacity-25'}"
			disabled={$form.processing}
			onclick={deleteUser}
		>
			Delete Account
		</Button>
	</div>
</Form>