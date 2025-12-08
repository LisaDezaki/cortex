<script>

	import clsx from 'clsx'
	import { onMount } from 'svelte'
	import Icon from '@/Components/UI/Icon.svelte'

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		switch: clsx('theme-switcher flex items-center gap-3 p-2 rounded text-sm text-left truncate hover:text-white',)
	})

	let darkMode = $state(localStorage.theme === "dark" || (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches));

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

	onMount(() => {
		setDarkMode(darkMode)
	})

</script>



<button onclick={toggleDarkMode} class={cx.switch}>
	{#if darkMode}
		<Icon name="Sun" size={20} />Light Mode
	{:else}
		<Icon name="Moon" size={20} />Dark Mode
	{/if}
</button>