<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form'

    let {
        oncancel
    } = $props()

    const form = useForm({
		image: null,
        name: null,
        description: null,
    })

    function submit(e) {
        e.preventDefault()
        $form.post( route('projects.store'), {
            onSuccess: () => oncancel(),
            onFinish: () => $form.reset(),
        })
    }

</script>

<Form
	class="space-y-3"
	title="Create a Project"
	onsubmit={submit}
	enctype="multipart/form-data"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<Form.Field>
		<Form.Label for="image" value="Image" />
		<Form.Upload
			id="image"
			bind:value={$form.image}
			class="aspect-[5/2]"
		/>
		<Form.Error message={$form.errors.image} />
	</Form.Field>

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
		<Form.Label for="description" value="Description" />
		<Form.Textarea
			id="description"
			bind:value={$form.description}
			rows={5}
		/>
		<Form.Error message={$form.errors.description} />
	</Form.Field>

	{#snippet actions()}
		<Button secondary type="button" label="Cancel" onclick={oncancel}  />
		<Button primary   type="submit" label="Start project" />
	{/snippet}

</Form>