import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import LocationList from '@/services/LocationList'
import { modalActions } from '@/stores/modalStore';

export default class LocationObject {
	constructor(locationData) {
		Object.assign(this, locationData, {
			// descendants: locationData.descendants ? new LocationList(locationData.descendants) : null,

			mapItems: locationData?.mapItems ? {
				all:		locationData.mapItems,
				characters: locationData.mapItems.filter(i => i.type === 'character'),
				factions:   locationData.mapItems.filter(i => i.type === 'faction'),
				locations:	locationData.mapItems.filter(i => i.type === 'location')
			} : [],
			routes: locationData ? {
				show:    route('locations.show',    { location: locationData.slug }),
				store:	 route('locations.store'),
				update:  route('locations.update',  { location: locationData.slug }),
				destroy: route('locations.destroy', { location: locationData.slug })
			} : null
		})
	}



	/**
	 * Modal Actions
	 * The following methods will open a modal with the designated props.
	 * Those modals will handle their own forms based on these props,
	 * but the initial form data can be overwritten from here.
	 */

	openModal(modalName, props) {

		switch(modalName) {
			case 'delete':
				modalActions.open('deleteLocation', { location: this }); break;
			case 'rename':
				modalActions.open('renameLocation', { location: this }); break;
			// case 'location':
			// 	modalActions.open('setLocation', ...props); break;
			// case 'relationship':
			// 	modalActions.open('setCharacterRelationship', { character: this, ...props }); break;
			case 'setBanner':
				modalActions.open('uploadMedia', {
					aspect: 'aspect-[3/1]',
					endpoint: this.routes.update,
					media: this.getBanner(),
					method: 'patch',
					reloadPageProps: ['location.media', 'locations.media'],
					title: 'Upload banner for ' + this.name,
					type: 'banner',
				}); break;
			case 'setMap':
				modalActions.open('uploadMedia', {
					aspect: 'aspect-square',
					endpoint: this.routes.update,
					media: this.getMap(),
					method: 'patch',
					reloadPageProps: ['location.media', 'locations.media'],
					title: 'Upload map for ' + this.name,
					type: 'map',
				}); break;
			default:
				console.log('LocationObject.openModal', modalName, props)
		}

	}


	/**
	 * Modal methods
	 */

	// addBanner() {
	// 	modalActions.open('uploadMedia', {
	// 		aspect: 'aspect-[7/3]',
	// 		endpoint: this.routes.update,
	// 		media: this.getBanner(),
	// 		method: 'patch',
	// 		reloadPageProps: ['location.media', 'locations.media'],
	// 		title: 'Upload banner for ' + this.name,
	// 		type: 'banner',
	// 	})
	// }

	// addMap() {
	// 	modalActions.open('uploadMedia', {
	// 		aspect: 'aspect-square',
	// 		endpoint: this.routes.update,
	// 		media: this.getMap(),
	// 		method: 'patch',
	// 		reloadPageProps: ['location.media', 'locations.media'],
	// 		type: 'map',
	// 	})
	// }

	// addPointOfInterest(entity) {
	// 	console.log('LocationObject.addPointOfInterest()', entity)
	// }

	// addTag(tag) {
	// 	console.log('LocationObject.addTag()', tag)
	// }

	// delete() {
	// 	modalActions.open('deleteLocation', { location: this })
	// }

	// rename() {
	// 	modalActions.open('renameLocation', { location: this })
	// }



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