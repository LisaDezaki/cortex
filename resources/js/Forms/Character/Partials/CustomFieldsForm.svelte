<script>
	import { useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import { Flex, Form } from '@/Components/Core'

	import Button from '@/Components/UI/Button.svelte'
	import Field from '@/Components/UI/Field.svelte'
	import Heading from '@/Components/UI/Heading.svelte'

	let {
		character,
		class: className,
		fields = $bindable(),
		values = $bindable(),
		...restProps
	} = $props()

	let editMode = $state(false)

	const form = useForm({
		customFields: fields.map((f => ({...f, value: findValue(f.id)})))
	})

	function findDisplayValue(fieldId) {
		return values.find(v => v.customFieldId == fieldId).displayValue || null
	}

	function findValue(fieldId) {
		return values.find(v => v.customFieldId == fieldId).value || null
	}

</script>





<Form
	route={ character ? route('characters.update', {character: character.slug}) : route('characters.store') }
	method={character ? 'patch' : 'post'}
	submitText={character ? 'Update' : 'Save'}
	class={className}
	initialData={form}
{...restProps}>

	<Flex items="center" justify="between" class="bg-neutral-softest mb-6 -mx-3 px-3 py-1.5 rounded-lg w-full">
		<Heading is="h3" as="h5" heading="Custom Fields" />
		<Flex justify="end" class="p-1.5">
			{#if editMode}
				<Button style="soft" theme="neutral" class="rounded-full"
					icon="X" type="button" onclick={() => editMode = false }
					disabled={$form.processing}
				/>
				<Button style="soft" theme="accent" class="rounded-full"
					icon="Check" type="submit"
					disabled={$form.processing}
				/>
			{:else}
				<Button style="soft" theme="neutral" class="rounded-full"
					icon="Pen" type="button" onclick={() => editMode = true }
				/>
			{/if}
		</Flex>
	</Flex>


	{#if fields == undefined || fields.length == 0}

		<p class="font-style-placeholder">There are no custom fields for Characters yet.</p>

	{:else}
		{#each fields as field, i}
			{#if editMode}

				<Field layout="block" inputClass="w-full" {...field} />

			{:else}

				<Flex gap={3}>
					<span class="font-bold w-20">{field.label}:</span>
					<span class="line-clamp-1 {findDisplayValue(field.id) ? '' : 'font-style-placeholder'}">{findDisplayValue(field.id) || "undefined"}</span>
				</Flex>

			{/if}
		{/each}
	{/if}

	{#if editMode}
		<Flex justify="end" class="mb-6 p-1.5">
			<Button style="soft" theme="neutral" class="rounded-full"
				icon="X" type="button" onclick={() => editMode = false }
				disabled={$form.processing}
			/>
			<Button style="soft" theme="accent" class="rounded-full"
				icon="Check" type="submit"
				disabled={$form.processing}
			/>
		</Flex>
	{/if}

</Form>


<!-- <pre>{JSON.stringify($form,null,3)}</pre> -->