<script>
    import GuestLayout from '@/Layouts/GuestLayout.svelte'
    import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form'
    import { route } from 'momentum-trail'
    import { useForm } from '@inertiajs/svelte'

    let { status } = $props()

    const form = useForm({
        email: '',
    })

    function submit(e) {
        e.preventDefault()

        $form.post(route('password.email'))
    }
</script>

<svelte:head>
    <title>Forgot Password</title>
</svelte:head>

<GuestLayout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset
        link that will allow you to choose a new one.
    </div>

    {#if status}
        <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
            {status}
        </div>
    {/if}

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

        <div class="mt-4 flex items-center justify-end">
            <Button primary class={$form.processing && 'opacity-25'} disabled={$form.processing}>
                Email Password Reset Link
            </Button>
        </div>
    </form>
</GuestLayout>
