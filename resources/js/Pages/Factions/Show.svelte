<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
    import FactionsLayout from '@/Layouts/FactionsLayout.svelte'
	import Article from '@/Components/Article.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Card from '@/Components/Card.svelte';
	// import CharacterCard from '@/Components/CharacterCard.svelte';
	import Icon from '@/Components/Icon.svelte'
	import Thumbnail from '@/Components/Thumbnail.svelte'

	let project = $page.props.active_project.data
	let faction = $page.props.faction.data

</script>

<svelte:head>
    <title>{project.name} / {faction.name}</title>
</svelte:head>

<FactionsLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",    href: "/" },
			{ title: "Factions", href: route('factions') },
			{ title: faction.name }
		]} />
	{/snippet}

	<!-- <pre>{JSON.stringify(faction, null, 4)}</pre> -->

	<section class="grid grid-cols-4 gap-12 px-12 py-6">
		<div class="col-span-3 space-y-6">

			<Article
				title={faction.name}
				subtitle="Faction Details"
				bodyclass="px-6 space-y-6"
			>
				<p class="mt-4 font-style-regular">
					{faction.description}
				</p>
			</Article>

			<Article
				title="Ranks"
				subtitle="Every faction has some kind of hierarchy, and these are the different levels of hierarchy in this faction."
				bodyclass="flex items-center gap-3 px-6"
			>
				{#each faction.ranks as rank}
					<div class="bg-slate-200 px-3 py-1.5 rounded-md">
						{rank.name}
					</div>
				{/each}
			</Article>

		</div>
		<div class="col-span-1 space-y-6">

			<div class="flex gap-3">
				<Button
					primary
					icon="Pen"
					label="Edit {faction.name}"
					href={route('factions.edit', {faction: faction.slug})}
					class="bg-emerald-500/20 flex p-2 rounded-lg rounded-r-none text-emerald-500 w-full"
				/>
				<Button
					danger
					icon="Trash"
					href={route('factions.edit', {faction: faction.slug})}
					class="bg-rose-500/20 flex p-2 rounded-lg rounded-l-none text-rose-500"
				/>
			</div>

			<Article>

				<div class="flex items-center justify-center aspect-square bg-slate-900/10 rounded-t-lg w-full border-b border-slate-900/15">
					{#if faction.image_path}
						<img src={faction.image_path} alt={faction.slug} class="w-full rounded-t-lg" />
					{:else}
						<Icon name="FlagBannerFold" size={64} weight="thin" />
					{/if}
				</div>

				<div class="flex flex-col gap-3 p-4 border-b border-slate-500/20">
					<h3 class="font-style-h5 text-emerald-500 text-center">Members</h3>
					<div class="flex flex-wrap justify-center gap-3 overflow-y-auto w-full">
						{#each faction.ranks as rank}
							{#each faction.members as member}
								{#if member.rank.id == rank.id}
									<Card
										title={member.name}
										subtitle={member.rank.name}
										image={member.image_path}
										href={route('characters.show', {character: member.slug})}
									/>
								{/if}
							{/each}
						{/each}
					</div>
				</div>

				<div class="p-4">
					{#if location.custom_field_values?.length > 0}
						{#each location.custom_field_values as field}
							<div class="grid grid-cols-2">
								<span class="col-span-1 px-2 py-1 font-bold border-r border-slate-500/15 text-right">{field.custom_field.label}</span>
								<span class="col-span-1 px-2 py-1">{field.value}</span>
							</div>
						{/each}
					{:else}
						No custom fields
					{/if}
				</div>

				{#each faction.custom_field_values as field}
					<div class="grid grid-cols-2">
						<span class="col-span-1 px-2 py-1 font-bold border-r border-slate-500/15 text-right">{field.custom_field.label}</span>
						<span class="col-span-1 px-2 py-1">{field.value}</span>
					</div>
				{/each}
			</Article>

		</div>
	</section>
</FactionsLayout>