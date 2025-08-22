<!-- <script>

	import { Flex } from '@/Components/Core'

	import Field from '@/Components/UI/Field.svelte'

	let {
		children,
		class: className,
		edit = false,
		fields = $bindable(),
		values = $bindable(),
		...restProps
	} = $props()

	function findValue(fieldId) {
		return values.find(v => v.customFieldId == fieldId).value || null
	}

</script>




<pre>{JSON.stringify(values,null,3)}</pre>




{#if fields == undefined || fields.length == 0}

	<p class="font-style-placeholder">There are no custom fields for Characters yet.</p>

{:else}
	{#each fields as field, i}
		{#if edit}

			<Field layout="block" inputClass="w-full"
				type={field.type}
				description={field.description}
				label={field.label || field.name}
				placeholder={field.placeholder || field.label}
				required={field.required}
				options={field.options}
				bind:value={findValue(field.id)}
			/>

		{:else}

			<Flex gap={3}>
				<span class="font-bold w-20">{field.label}</span>
				<span class="line-clamp-1 {findValue(field.id) ? '' : 'font-style-placeholder'}">{findValue(field.id) || "undefined"}</span>
			</Flex>

		{/if}
	{/each}
{/if} -->