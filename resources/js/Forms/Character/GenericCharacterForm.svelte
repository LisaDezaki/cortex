<script>
	// import { setContext, getContext } from 'svelte';
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import { Form } from '@/Components/Core'

	// const FORM_CONTEXT = Symbol('form_context'); // Context keys

	// Create form instance
	// const formInstance = useForm({});
  
	// Provide form context to child components

	let {
		character,
		children,
		class:className,
		...restProps
	} = $props()

	// setContext(FORM_CONTEXT, {
	// 	form: formInstance,
	// 	endpoint: character ? route('characters.update', {character: slug}) : route('characters.store'),
	// 	method: character ? 'patch' : 'post'
	// });

	// let startData = {
    //     slug: character?.slug || null,
	// 	portrait: character?.portrait?.path || null,
    //     name: character?.name || null,
	// 	alias: character?.alias || null,
    //     description: character?.description || null,
	// 	faction_id: character?.factions?.[0]?.id || null,
	// 	location_id: character?.location?.id || null,
	// 	relationships: character?.relationships || null,
	// 	appearance: character?.appearance || [],
	// 	personality: character?.personality || [],
	// 	custom_fields: character?.customFields || []
	// }

    // function submit(e) {
    //     e.preventDefault()
	// 	if (character) { updateCharacter(character.slug) }
	// 	else           { createCharacter() }
    // }

	// function createCharacter() {
	// 	$form.post(route('characters.store'))
	// }

	// function updateCharacter(slug) {
	// 	$form.patch(route('characters.update', {character: slug}))
	// }
	
</script>



<Form
	route={ character ? route('characters.update', {character: slug}) : route('characters.store') }
	method={character ? 'patch' : 'post'}
	submitText={character ? 'Update' : 'Save'}
	class={className}
{...restProps}>
	{@render children?.()}
</Form>