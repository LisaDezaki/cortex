<script>
    import { inertia, page, useForm } from '@inertiajs/svelte'

	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form.svelte'

    import Transition from 'svelte-transition'
    import { route } from 'momentum-trail'

    let {
        mustVerifyEmail,
        status,
    } = $props()

    const user = $page.props.auth.user.data
    const form = useForm({
        name: user.name,
        email: user.email,
    })

    function submit(e) {
        e.preventDefault()
        $form.patch(route('profile.update'))
    }
</script>

<Form
	class="mt-6 space-y-2"
	mustVerifyEmail={mustVerifyEmail}
	onsubmit={submit}
	submitLabel="Save Profile"
>
	<Form.Field>
		<Form.Label for="name" value="Name" />
		<Form.Input
			id="name"
			type="text"
			bind:value={$form.name}
			required
			autofocus
			autocomplete="name"
		/>
		<Form.Error message={$form.errors.name} />
	</Form.Field>

	<Form.Field>
		<Form.Label for="email" value="Email" />
		<Form.Input
			id="email"
			type="email"
			bind:value={$form.email}
			required
			autocomplete="username"
		/>
		<Form.Error class="mt-2" message={$form.errors.email} />
	</Form.Field>
</Form>