<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import LocationsLayout from '@/Layouts/LocationsLayout.svelte'
	import Article from '@/Components/Article.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button from '@/Components/Button.svelte'
	import Card from '@/Components/Card.svelte'
	// import CharacterCard from '@/Components/CharacterCard.svelte'
	import Icon from '@/Components/Icon.svelte'
	import Thumbnail from '@/Components/Thumbnail.svelte'

	let project = $page.props.active_project.data
	let location = $page.props.location.data

</script>

<svelte:head>
    <title>{project.name} / {location.name}</title>
</svelte:head>

<LocationsLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",    href: "/" },
			{ title: "Locations", href: route('locations') },
			{ title: location.name }
		]} />
	{/snippet}

	<!-- <pre>{JSON.stringify(location, null, 4)}</pre> -->

	<section class="grid grid-cols-5 gap-12 px-12 py-6">
		<div class="col-span-3 space-y-8">

			<Article class="p-8">
				<header class="relative">
					<h2 class="font-style-h4">{location.name}</h2>
					<span class="font-style-large">{location.region?.name}</span>
					<!-- <div class="flex absolute top-0 right-0">
						<Button
							plain
							icon="Pen"
							iconSize={24}
							href={route('locations.edit', {location: location.slug})}
							class="bg-emerald-500/20 flex px-2 py-1 rounded-lg rounded-tr-none rounded-br-none text-emerald-500"
						/>
						<Button
							plain
							icon="Trash"
							iconSize={24}
							href={route('locations.edit', {location: location.slug})}
							class="bg-rose-500/20 flex px-2 py-1 rounded-lg rounded-tl-none rounded-bl-none text-rose-500"
						/>
					</div> -->
				</header>
			
				<p class="mt-4 font-style-regular">
					{location.description}
				</p>
			</Article>

			{#if location.characters.length > 0}
				<div class="px-8">
					<h4 class="font-style-h6 mb-2">Characters</h4>
					<div class="grid grid-cols-4 gap-2">
						{#each location.characters as character}
							<Card
								class="aspect-[3/4]"
								title={character.name}
								subtitle={character.subtitle}
								image={character.image_path}
								href={route('characters.show', {character: character.slug})}
							/>
						{/each}
					</div>
				</div>
			{/if}

		</div>
		<div class="col-span-2 space-y-6">

			<div class="flex gap-3">
				<Button
					primary
					icon="Pen"
					label="Edit {location.name}"
					href={route('locations.edit', {location: location.slug})}
					class="bg-emerald-500/20 flex p-2 rounded-lg rounded-r-none text-emerald-500 w-full"
				/>
				<Button
					danger
					icon="Trash"
					href={route('locations.edit', {location: location.slug})}
					class="bg-rose-500/20 flex p-2 rounded-lg rounded-l-none text-rose-500"
				/>
			</div>

			<Article>

				<div class="flex items-center justify-center aspect-video bg-slate-900/10 rounded-t-lg w-full border-b border-slate-900/15 overflow-hidden">
					{#if location.image_path}
						<img src={location.image_path} alt={location.name} class="min-h-full min-w-full object-cover" />
					{:else}
						<Icon name="MapPin" size={64} weight="thin" />
					{/if}
				</div>

				<div class="p-4">
					{#if location.custom_field_values?.length > 0}
						{#each location.custom_field_values as field}
							<div class="grid grid-cols-2">
								<span class="col-span-1 px-2 py-1 font-bold border-r border-black/15 text-right">{field.custom_field.label}</span>
								<span class="col-span-1 px-2 py-1">{field.value}</span>
							</div>
						{/each}
					{:else}
						No custom fields
					{/if}
				</div>

			</Article>

		</div>



	</section>

</LocationsLayout>