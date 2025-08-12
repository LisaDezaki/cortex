<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

    import GuestLayout from '@/Layouts/GuestLayout.svelte'

    import { Form } from '@/Components/Core'
    import Button from '@/Components/UI/Button.svelte'
    import Field from '@/Components/UI/Field.svelte'

    const form = useForm({
        password: '',
    })

    function submit(e) {
        e.preventDefault()

        $form.post(route('password.confirm'), {
            onFinish: () => $form.reset(),
        })
    }
</script>

<svelte:head>
    <title>Confirm Password</title>
</svelte:head>

<GuestLayout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        This is a secure area of the application. Please confirm your password before continuing.
    </div>

    <Form onsubmit={submit}>
        <Field
			id="password"
			type="password"
			class="mt-1 block w-full"
			label="Password"
			bind:value={$form.password}
			errors={$form.errors.password}
			required
			autocomplete="current-password"
			autofocus
		/>

        <div class="mt-4 flex justify-end">
            <Button style="hard" theme="accent"
				class="ms-4 {$form.processing && 'opacity-25'}"
				disabled={$form.processing}
				label="Confirm"
			/>
        </div>
    </Form>
</GuestLayout>