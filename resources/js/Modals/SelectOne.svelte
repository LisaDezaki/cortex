<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Box, Flex, Stack, UploadContext } from '@/Components/Core'
	import Field	 from '@/Components/UI/Field.svelte'
	import Heading	 from '@/Components/UI/Heading.svelte'
	import ModalForm from '@/Components/UI/ModalForm.svelte'
	import Tag		 from '@/Components/UI/Tag.svelte'
    import clsx from 'clsx'

    let {
		endpoint,
		location,
		method,
		options = [],
		tags = $bindable([]),
		title = "Set Tags"
	} = $props()

	const form = useForm({
		tags: tags
	})

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		active: clsx('bg-accent-softest text-accent'),
		tag: 	clsx('bg-neutral-softest text-neutral-soft hover:text-neutral'),
	})

	function toggleTag(tag) {
		let isActive = $form.tags?.includes(tag)
		$form.tags = isActive
			? [...$form.tags.filter(t => t !== tag) ]
			: [...$form.tags, tag ]
	}

</script>



<ModalForm
	endpoint={endpoint}
	form={form}
	method="patch"
	size="xl"
	submitProps={{
		label: 'Save'
	}}
	title={title}
>
	Select One
</ModalForm>