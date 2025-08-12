<script>
    import { inertia, page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'
	import Transition from 'svelte-transition'

	import { Form }   from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field from '@/Components/UI/Field.svelte'

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

	<Field type="text"
		id="name"
		label="Name"
		bind:value={$form.name}
		errors={$form.errors.name}
		autocomplete="name"
		autofocus
		required
	/>

	<Field type="email"
		id="email"
		label="Email"
		bind:value={$form.email}
		errors={$form.errors.email}
		autocomplete="username"
		required
	/>
	
</Form>