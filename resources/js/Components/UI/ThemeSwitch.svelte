<script>

	import Icon from '@/Components/UI/Icon.svelte'

	let darkMode = localStorage.theme === "dark" || (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches);

	setDarkMode(darkMode);

	function setDarkMode() {
		if (darkMode) {
			document.documentElement.setAttribute('data-theme', 'dark');
		} else {
			document.documentElement.setAttribute('data-theme', 'light');
		}
	}

	function toggleDarkMode() {
		darkMode = !darkMode;
		setDarkMode();
	}

</script>

<button onclick={toggleDarkMode} class="theme-switcher">
	{#if darkMode}
		<Icon name="Sun" size={20} />Light Mode
	{:else}
		<Icon name="Moon" size={20} />Dark Mode
	{/if}
</button>

<style lang="postcss">

	.theme-switcher {
		@apply flex items-center gap-3 p-2;
		@apply rounded text-sm text-left truncate;
	}

	.theme-switcher:hover {
		color: var(--text-white);
	}

</style>