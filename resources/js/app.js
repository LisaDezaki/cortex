import '../css/app.css'
import '../css/fonts.css'
import './bootstrap'

import { createInertiaApp } from '@inertiajs/svelte'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { defineRoutes } from 'momentum-trail'
import { hydrate, mount } from 'svelte'
import routes from './routes.json'

const ICON_XS = 12
const ICON_SM = 16
const ICON_MD = 20
const ICON_LG = 24

let darkMode = localStorage.theme === "dark" || (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches);

setDarkMode(darkMode);

function setDarkMode() {
	if (darkMode) {
		document.documentElement.setAttribute('data-theme', 'dark');
	} else {
		document.documentElement.setAttribute('data-theme', 'light');
	}
}

defineRoutes(routes)

createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.svelte`, import.meta.glob('./Pages/**/*.svelte')),
    setup({ el, App }) {
        if (el.dataset.serverRendered === 'true') {
            hydrate(App, { target: el })
        } else {
            mount(App, { target: el })
        }
    },
})
