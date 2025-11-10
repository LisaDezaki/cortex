/**
 * @typedef {import('@inertiajs/svelte')} router
 * @typedef {import('momentum-trail')} route
 * @typedef {import('@/stores/modalStore')} modalActions
 */

import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'
import { modalActions } from '@/stores/modalStore';

/**
 * Class: User Object
 * Represents a single User record
 * @class
 * @classdesc A User entity as fetched from the database
 * with other functionality to make data handling easier
 */

export default class UserObject {

	/**
	 * Creates a new UserObject instance
	 * @param {Object} userData
	 * @throws {TypeError} if userData is not provided
	 */
	constructor(userData) {
		Object.assign(this, userData, {

			/**
			 * API routes for user operations
			 * @type {Object}
			 * @property {string} update  | Route for updating this user
			 * @property {string} destroy | Route for destroying this user
			 */
			routes: {
				update:  route('user.update'),
				destroy: route('user.destroy')
			}
		})
	}


	/**
	 * Open Modal
	 * Open any of the available modals with associated props
	 * @param {string} modalName | the name of the modal to open
	 * @param {Array}  props     | any additional props to be added
	 */
	openModal(modalName, props) {

		switch(modalName) {
			case 'delete':
				modalActions.open('deleteUser', { user: this }); break;
			case 'rename':
				modalActions.open('renameUser', { user: this }); break;
			case 'setAvatar':
				modalActions.open('uploadMedia', {
					aspect: 'aspect-square',
					endpoint: this.routes.update,
					media: this.getMedia('avatar'),
					method: 'patch',
					reloadPageProps: ['auth.user.image', 'auth.user.media'],
					type: 'avatar',
				}); break;
			default:
				console.log('UserObject.openModal', modalName, props)
		}
	}


	/**
	 * Get Media
	 * @param {string} type | The "type" of media to filter
	 * @returns {Object} first media instance with specified type
	 */
	getMedia(type) {
		return type ? this.media?.filter(m => m.type === type)?.[0] : null
	}

	/**
	 * Get All Media
	 * @param {string} type | The "type" of media to filter
	 * @returns {Array} all media instances with specified type
	 */
	getAllMedia(type) {
		return type ? this.media?.filter(m => m.type === type) : null
	}

	

	/**
	 * Controller - Update
	 * @param {Object} data | The data to UPDATE on the database
	 */
	_update(data) {
		router.patch( this.routes.update, data, {
			onFinish: () => router.visit( router.page.url, { only: ['auth.user'] })
		})
	}

	/**
	 * Controller - Destroy
	 * @param {Object} data | The data to DESTROY on the database
	 */
	_destroy(data) {
		router.destroy( this.routes.destroy, data, {
			onFinish: () => router.visit( router.page.url, { only: ['characters', 'character'] })
		})
	}
}