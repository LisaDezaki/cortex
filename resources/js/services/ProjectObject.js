import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import CharacterList from '@/services/CharacterList'
import FactionList from '@/services/FactionList'
import LocationList from '@/services/LocationList'
import { modalActions } from '@/stores/modalStore';

export default class ProjectObject {
	constructor(projectData) {
		Object.assign(this, projectData, {
			characters: projectData.characters ? new CharacterList(projectData.characters)	: null,
			factions:   projectData.factions   ? new FactionList(projectData.factions)		: null,
			locations:  projectData.locations  ? new LocationList(projectData.locations)	: null,
			routes: {
				activate:	route('projects.activate',	{ project: projectData.id }),
				deactivate: route('projects.deactivate'),
				show:		route('projects.show',		{ project: projectData.id }),
				update:		route('projects.update',	{ project: projectData.id })
			}
		})
	}



	/**
	 * Modal methods
	 */

	addBanner() {
		modalActions.open('uploadMedia', {
			aspect: 'aspect-[7/3]',
			endpoint: this.routes.update,
			media: this.getBanner(),
			method: 'patch',
			reloadPageProps: ['activeProject.media', 'projects.media'],
			title: "Upload Project banner",
			type: 'banner',
		})
	}

	destroy() {
		modalActions.open('deleteProject', 	{ project: this })
	}

	rename() {
		modalActions.open('renameProject', 	{ project: this })
	}



	/**
	 * Media methods
	 */

	getBanner() {
		return this.media?.filter(m => m.type === 'banner')?.[0] || null
	}


	
	/**
	 * Server methods
	 */

	activate() {
		router.post(
			this.routes.activate, {}, {
				onFinish: () => {
					router.visit( router.page.url, { only: ['activeProject'] })
				}
			}
		)
	}

	deactivate() {
		router.post(
			this.routes.deactivate, {}, {
				onFinish: () => router.visit( router.page.url, { only: ['activeProject'] })
			}
		)
	}


	/**
	 * HTTP methods
	 */
	
	_update(data) {
		router.patch(
			this.routes.update, data, {
				onFinish: () => router.visit( router.page.url, { only: ['activeProject'] })
			}
		)
	}
}