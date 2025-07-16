<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import CharactersLayout from '@/Layouts/CharactersLayout.svelte'
	import CharacterForm from './Partials/CharacterForm.svelte'
	import Article from '@/Components/Article.svelte';
	import Back from '@/Components/Back.svelte';
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte';
	import Button from '@/Components/Button.svelte';
	import Sidebar from '@/Components/Sidebar.svelte';

	let project = $page.props.active_project

</script>

<svelte:head>
    <title>{project.name} / New Character</title>
</svelte:head>

<CharactersLayout>
	{#snippet header()}
		<Breadcrumbs data={[
			{ title: "Project",    href: "/" },
			{ title: "Characters", href: route('characters') },
			{ title: "Create" }
		]} />
		<Button plain iconSize={24} iconWeight="light" icon="Plus"     href={route('characters.create')}   class="inline-flex items-center justify-center w-12 flex-shrink-0 aspect-square border-l hover:bg-emerald-500/10 text-emerald-500" />
	{/snippet}

	<Article class="w-full px-20 py-12 overflow-y-auto" bodyclass="space-y-6">
		<Back href={route('characters')} />
		<CharacterForm />
	</Article>

	<Sidebar>
	</Sidebar>

</CharactersLayout>