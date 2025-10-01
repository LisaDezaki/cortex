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
        $form.patch(route('user.update'))
    }
</script>

<Form form={form}
	class="mt-6 space-y-2"
	mustVerifyEmail={mustVerifyEmail}
	onsubmit={submit}
	submitLabel="Save Profile"
>
	<Field type="text"
		name="name"
		label="Name"
		autocomplete="name"
		autofocus
		required
	/>

	<Field type="email"
		name="email"
		label="Email"
		autocomplete="username"
		required
	/>
	
</Form>