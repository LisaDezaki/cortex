<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
	import {
		Form, Grid,
		UploadContext,
		UploadPreview,
		UploadTrigger
	} from '@/Components/Core';

	import Button    from '@/Components/UI/Button.svelte'
	import Card      from '@/Components/UI/Card.svelte'
	import CardNew   from '@/Components/UI/CardNew.svelte'
	import Field     from '@/Components/UI/Field.svelte'
	import Heading   from '@/Components/UI/Heading.svelte'
	import Input    from '@/Components/UI/Input.svelte'
	import Section   from '@/Components/UI/Section.svelte'
	import Tabs      from '@/Components/UI/Tabs'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	import CharacterCard from '@/Components/Features/Character/CharacterCard.svelte'

	const activeProject = $page.props.activeProject.data
	const customFields  = $page.props.customFields?.data

	let { locationData, oncancel } = $props()

	let characters = $derived(activeProject?.characters.filter(c => c.location === null) || null)
	let locations  = $derived(activeProject?.locations)

	let startData = {
		slug: locationData?.slug || null,
		is_world_map: locationData?.isWorldMap || null,
		banner: locationData?.banner?.path || null,
		parent: locationData?.parent?.id || null,
		map: locationData?.map?.path || null,
        name: locationData?.name || null,
        description: locationData?.description || null,
		characters: locationData?.characters || [],
		custom_fields: locationData?.custom_fields || []
	}

	const form = useForm(startData)

    function submit(e) {
        e.preventDefault()
		if (locationData) {
			updateLocation(locationData.slug)
		} else              {
			createLocation()
		}
    }

	function createLocation() {
		$form.post(route('locations.store'))
	}

	function updateLocation(slug) {
		$form.patch(route('locations.update', {location: slug}))
	}
	
</script>


<Form class="grid grid-cols-2 overflow-hidden max-w-[86vw]">

	<!-- MAP -->

	<UploadContext class="col-span-1 relative flex aspect-square border-r bg-slate-500/10"
		bind:value={$form.map} preview={locationData?.map?.url}
	>
		<UploadPreview class="h-full w-full flex items-center justify-center">
			<UploadTrigger icon="Image" label={$form.map ? "Replace Map" : "Upload Map"} />
		</UploadPreview>
	</UploadContext>

	<!-- MAIN INFORMATION -->

	<div class="col-span-1 flex flex-col h-full p-3 aspect-square overflow-hidden">
		<Tabs value="tab1" class="h-full">
			<Tabs.List class="w-full">
				<Tabs.Trigger value="tab1">General</Tabs.Trigger>
				<Tabs.Trigger value="tab2">Characters</Tabs.Trigger>
				<Tabs.Trigger value="tab3">Custom Fields</Tabs.Trigger>
			</Tabs.List>
	
			<Tabs.Content value="tab1">

				<UploadContext bind:value={$form.banner} preview={locationData?.banner?.url} class="aspect-[22/9] relative flex items-center justify-center border-r overflow-hidden rounded-lg bg-slate-500/10 mb-3">
					<UploadPreview class="h-full w-full flex items-center justify-center">
						<UploadTrigger icon="Image" label={$form.banner ? "Replace Banner" : "Upload Banner"} />
					</UploadPreview>
				</UploadContext>

				<div class="grid grid-cols-2 gap-6 mt-6 mb-6 px-3">
					<Input class="col-span-1" inputClass="w-full"
						type="select"
						id="parent"
						label="Parent"
						description="Which location this location is found within."
						placeholder="Select parent location..."
						bind:value={$form.parent}
						errors={$form.errors.parent}
						options={locations?.map(r => {
							return { label: r.name, value: r.slug }
						})}
						disabled={$form.is_world_map}
					/>
					<Input class="col-span-1"
						type="checkbox"
						id="worldMap"
						labelText="World Map"
						bind:checked={$form.is_world_map}
						errors={$form.errors.is_world_map}
						required
					/>
				</div>


				<Field layout="inline" class="px-3" inputClass="w-full"
					type="text"
					id="name"
					label="Name"
					description="The name of this location."
					placeholder="Name"
					bind:value={$form.name}
					errors={$form.errors.name}
					required
				/>

				<Field class="px-3" inputClass="w-full"
					type="textarea"
					id="description"
					label="Description"
					placeholder="Description..."
					bind:value={$form.description}
					description="A detailed description of the location."
					errors={$form.errors.description}
					rows={4}
				/>
			</Tabs.Content>
	
			<Tabs.Content value="tab2">

				<Heading heading="Characters" is="h5" as="h6" class="mb-3 px-2" />
				<Grid cols={5} class="overflow-y-auto px-2 w-full">
					{#each $form.characters as character (character.id)}
						<CharacterCard {character} />
					{/each}
					<CardNew aspect="square" class="w-full" />
				</Grid>
				

				<!-- {#if characters.length > 0}
					<Heading heading="Characters" is="h5" as="h6" class="mb-3 px-2" />
					<Grid cols={5} class="overflow-y-auto px-2 w-full">
						{#each characters as character (character.id)}
							<CharacterCard {character}
								disabled={character.location !== null}
							/>
						{/each}
					</Grid>
				{:else}
					<p class="font-style-placeholder px-3">There are no characters without locations in this project.</p>
				{/if} -->
			</Tabs.Content>
	
			<Tabs.Content value="tab3">
				Custom Fields
			</Tabs.Content>
		</Tabs>

	</div>
</Form>

<Section class="border-t flex items-center justify-center gap-3 p-3">
	<Button style="hard" theme="neutral"
		type="button"
		label="Cancel"
		onclick={oncancel}
	/>
	<Button style="hard" theme="accent"
		type="submit"
		disabled={!$form.isDirty || $form.processing || $form.recentlySuccessful}
		label="{locationData ? "Update" : "Create"} Location"
		onclick={submit}
	/>
</Section>