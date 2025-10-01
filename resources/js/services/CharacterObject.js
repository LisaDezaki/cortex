import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import { modalActions } from '@/stores/modalStore';

export default class CharacterObject {
    constructor(characterData) {
        Object.assign(this, characterData, {
			routes: {
				show:    route('characters.show',    { character: characterData.slug }),
				store:   route('characters.store'),
				update:  route('characters.update',  { character: characterData.slug }),
				destroy: route('characters.destroy', { character: characterData.slug })
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
			reloadPageProps: ['character.media', 'characters.media'],
			type: 'banner',
		})
	}

	addFaction() {
		console.log('CharacterObject.addFaction()')
	}

	addGallery() {
		modalActions.open('uploadMedia', { type: 'gallery' })
	}

	addLocation() {
		console.log('CharacterObject.addLocation()')
	}

	addPortrait() {
		modalActions.open('uploadMedia', {
			aspect: 'aspect-square',
			endpoint: this.routes.update,
			media: this.getPortrait(),
			method: 'patch',
			reloadPageProps: ['character.media', 'characters.media'],
			type: 'portrait',
		})
	}

	addRelationship() {
		console.log('CharacterObject.addRelationship()')
		modalActions.open('setCharacterRelationship', { character: this })
	}

	addTag(tag) {
		console.log('CharacterObject.addTag()', tag)
	}

	delete() {
		modalActions.open('deleteCharacter', { character: this })
	}

	rename() {
		modalActions.open('renameCharacter', { character: this })
	}



	/**
	 * 	Media methods
	 */

	getBanner() {
		return this.media?.filter(m => m.type === 'banner')?.[0] || null
	}

	getPortrait() {
		return this.media?.filter(m => m.type === 'portrait')?.[0] || null
	}

	uploadBanner() {
		console.log('CharacterObject.uploadBanner()')
	}

	uploadGallery() {
		console.log('CharacterObject.uploadGallery()')
	}

	uploadPortrait() {
		console.log('CharacterObject.uploadPortrait()')
	}



	/**
	 * 	Update methods
	 */

	removeFaction() {
		console.log('CharacterObject.removeFaction()')
		this.setFaction()
	}

	removeLocation() {
		console.log('CharacterObject.removeLocation()')
		this._update({ location_id: null })
	}

	setFaction(faction) {
		console.log('CharacterObject.setFaction()', faction?.name)
		this._update({ faction_id: faction?.id || null })
	}

	setLocation(location) {
		console.log('CharacterObject.setLocation()', location?.name)
		this._update({ location_id: location?.id || null })
	}

	star() {
		this._update({ starred: !Boolean(this.starred) })
	}



	/**
	 * 	HTTP methods
	 */

	_store(data) {
		router.post(
			this.routes.store, data, {
				onFinish: () => router.visit( router.page.url, { only: ['characters'] })
			}
		)
	}

	_update(data) {
		router.patch(
			this.routes.update, data, {
				onFinish: () => router.visit( router.page.url, { only: ['characters'] })
			}
		)
	}

	_destroy(data) {
		router.destroy(
			this.routes.destroy, data, {
				onFinish: () => router.visit( router.page.url, { only: ['characters'] })
			}
		)
	}
}