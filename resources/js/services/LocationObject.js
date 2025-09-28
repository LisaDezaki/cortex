import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import { modalActions } from '@/stores/modalStore';

export default class LocationObject {
	constructor(locationData) {
		Object.assign(this, locationData, {
			routes: {
				show:    route('locations.show',    { location: locationData.slug }),
				store:	 route('locations.store'),
				update:  route('locations.update',  { location: locationData.slug }),
				destroy: route('locations.destroy', { location: locationData.slug })
			}
		})
	}


	/**
	 * Modal methods
	 */

	addBanner() {
		modalActions.open('uploadMedia', {
			aspect: 'aspect-[3/1]',
			endpoint: this.routes.update,
			media: this.getBanner(),
			method: 'patch',
			reloadPageProps: ['location.media', 'locations.media'],
			type: 'banner',
		})
	}

	addMap() {
		modalActions.open('uploadMedia', {
			aspect: 'aspect-square',
			endpoint: this.routes.update,
			media: this.getMap(),
			method: 'patch',
			reloadPageProps: ['location.media', 'locations.media'],
			type: 'map',
		})
	}

	addPointOfInterest(entity) {
		console.log('LocationObject.addPointOfInterest()', entity)
	}

	addTag(tag) {
		console.log('LocationObject.addTag()', tag)
	}

	delete() {
		modalActions.open('deleteLocation', { location: this })
	}

	rename() {
		modalActions.open('renameLocation', { location: this })
	}



	/**
	 * 	Media methods
	 */

	getBanner() {
		return this.media?.filter(m => m.type === 'banner')?.[0] || null
	}

	getMap() {
		return this.media?.filter(m => m.type === 'map')?.[0] || null
	}






	/**
	 * 	Update methods
	 */

	removePointOfInterest(entity) {
		console.log('LocationObject.removePointOfInterest()', entity)
	}

	star() {
		console.log('LocationObject.star()')
		this._update({ starred: !Boolean(this.starred) })
	}



	/**
	 * 	HTTP methods
	 */

	_update(data) {
		router.patch(
			this.routes.update, data, {
				onFinish: () => router.visit( router.page.url, { only: ['locations'] })
			}
		)
	}
}