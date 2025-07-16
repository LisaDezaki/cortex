<script>
    import GuestLayout from '@/Layouts/GuestLayout.svelte'
    import Button from '@/Components/Button.svelte'
    import Form from '@/Components/Form'
    import { route } from 'momentum-trail'
    import { useForm } from '@inertiajs/svelte'

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

    <form onsubmit={submit}>
        <div>
            <Form.Label for="password" value="Password" />
            <Form.Input
                id="password"
                type="password"
                class="mt-1 block w-full"
                bind:value={$form.password}
                required
                autocomplete="current-password"
                autofocus
            />
            <Form.Error message={$form.errors.password} />
        </div>

        <div class="mt-4 flex justify-end">
            <Button primary class="ms-4 {$form.processing && 'opacity-25'}" disabled={$form.processing}
                >Confirm</Button
            >
        </div>
    </form>
</GuestLayout>