<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

    import GuestLayout from '@/Layouts/GuestLayout.svelte'
	import ResetPasswordForm from '@/Forms/Auth/ResetPasswordForm.svelte'
    import Form from '@/Components/Core/Form.svelte'
    import Button from '@/Components/UI/Button.svelte'
    import Field from '@/Components/UI/Field.svelte'
	import Heading from '@/Components/UI/Heading.svelte'

    let { email, status, token } = $props()

    // const form = useForm({
    //     token: token,
    //     email: email,
    //     password: '',
    //     password_confirmation: '',
    // })

    // function submit(e) {
    //     e.preventDefault()

    //     $form.post(route('password.store'), {
    //         onFinish: () => $form.reset('password', 'password_confirmation'),
    //     })
    // }
</script>



<svelte:head>
    <title>Reset Password</title>
</svelte:head>

<GuestLayout>
	<div class="bg-surface rounded-lg w-96">
		<Heading is="h1" as="h5" class="px-6 pt-3 text-neutral-softest">Reset Password</Heading>
		{#if status}
			<div class="text-sm font-medium text-accent mb-6">
				{status}
			</div>
		{/if}
		<ResetPasswordForm />
	</div>

    <!-- <Form title="Reset Password" onsubmit={submit} class="form-styles w-96">
        <div>
            <Form.Label for="email" value="Email" />
            <Form.Input
                id="email"
                type="email"
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
    </Form> -->
</GuestLayout>
