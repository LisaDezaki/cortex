<script>
    import GuestLayout from '@/Layouts/GuestLayout.svelte'
    import Button from '@/Components/Button.svelte'
    import { route } from 'momentum-trail'
    import { useForm } from '@inertiajs/svelte'

    let { email, token } = $props()

    const form = useForm({
        token: token,
        email: email,
        password: '',
        password_confirmation: '',
    })

    function submit(e) {
        e.preventDefault()

        $form.post(route('password.store'), {
            onFinish: () => $form.reset('password', 'password_confirmation'),
        })
    }
</script>

<svelte:head>
    <title>Reset Password</title>
</svelte:head>

<GuestLayout>
    <form onsubmit={submit}>
        <div>
            <Form.Label for="email" value="Email" />
            <Form.Input
                id="email"
                type="email"
                class="mt-1 block w-full"
                bind:value={$form.email}
                required
                autofocus
                autocomplete="username"
            />
            <Form.Error class="mt-2" message={$form.errors.email} />
        </div>

        <div class="mt-4">
            <Form.Label for="password" value="Password" />
            <Form.Input
                id="password"
                type="password"
                class="mt-1 block w-full"
                bind:value={$form.password}
                required
                autocomplete="new-password"
            />
            <Form.Error class="mt-2" message={$form.errors.password} />
        </div>

        <div class="mt-4">
            <Form.Label for="password_confirmation" value="Confirm Password" />

            <Form.Input
                id="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                bind:value={$form.password_confirmation}
                required
                autocomplete="new-password"
            />

            <Form.Error class="mt-2" message={$form.errors.password_confirmation} />
        </div>

        <div class="mt-4 flex items-center justify-end">
            <Button primary class={$form.processing && 'opacity-25'} disabled={$form.processing}
                >Reset Password</Button
            >
        </div>
    </form>
</GuestLayout>
