<script>
	import { route } from 'momentum-trail'
    import { useForm } from '@inertiajs/svelte'

    import GuestLayout from '@/Layouts/GuestLayout.svelte'
    import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form.svelte'
    import Field from '@/Components/Field.svelte'

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
    <!-- <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset
        link that will allow you to choose a new one.
    </div> -->

    {#if status}
        <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
            {status}
        </div>
    {/if}

    <Form title="Forgot Password" onsubmit={submit} class="form-styles w-96">

		<Field
			id="email"
			type="email"
			label="Email"
			icon="At"
			bind:value={$form.email}
			errors={$form.errors.email}
			required
			autocomplete="username"
		/>

		<Button style="hard" theme="accent"
			class="w-full {$form.processing && 'opacity-25'}"
			disabled={$form.processing}
			label="Email Password Reset Link"
		/>
    </Form>
</GuestLayout>
