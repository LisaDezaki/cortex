<script>
    import { page, useForm } from '@inertiajs/svelte'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Button 	 from '@/Components/UI/Button.svelte'
	import Field 	 from '@/Components/UI/Field.svelte'
	import ModalForm from '@/Components/UI/ModalForm.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

    import { route } from 'momentum-trail'

	const user = $page.props.auth.user.data

	let {
		class: className,
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





<ModalForm title="Deleting Account" size="md"
	endpoint={route('profile.destroy')}
	form={form}
	method="delete"
	reloadPageProps={['users']}
	submitProps={{ label: 'Yes, Delete', theme: 'danger' }}
{...restProps}>

	<Stack align="center" gap={3} class="px-6 pb-6">

		<Thumbnail class="aspect-square my-1.5 rounded-full w-32" src={user.avatar?.url} />

		<p class="font-style-small px-3 text-center">Once your account is deleted, all of projects and their related data will be permanently removed.</p>
		
		<Field type="password" class="w-full"
			inputClass="max-w-full"
			name="password"
			label="Password" labelSrOnly
			errors={$form.errors.password}
			required
		/>

		<p class="font-style-small text-center"><strong>Enter your password to delete your account</strong></p>

	</Stack>


	<!-- <div class="mt-6 flex justify-end">
		<Button style="hard" theme="neutral" onclick={oncancel}>Cancel</Button>

		<Button style="hard" theme="danger"
			class="ms-3 {$form.processing && 'opacity-25'}"
			disabled={$form.processing}
			type="submit"
		>
			Delete Account
		</Button>
	</div> -->
</ModalForm>