<script>

	import { page, router, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	let {
		activeClass,
		class: className,
		children,
		projectId,
        ...restProps
    } = $props()

	let activeProject 	= $state($page.props.activeProject?.data)

	let isActive        = $derived(activeProject?.id === projectId)

	let form = useForm({})

	function activate() {

		let formRoute = isActive
			? route('projects.deactivate')
			: route('projects.activate', { project: projectId })

		$form.post(
			formRoute,
			{ onSuccess: (res) => {
				router.visit(route('dashboard'), {
					only: ['activeProject'],
				})
			}}
		)
	}

</script>

<button
	class="project-activator {className} {isActive ? activeClass : ""}"
	onclick={activate}
	{...restProps}
>
	{@render children?.()}
</button>