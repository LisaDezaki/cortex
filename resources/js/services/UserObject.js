import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import { modalActions } from '@/stores/modalStore';

export default class UserObject {
	constructor(userData) {
		Object.assign(this, userData, {
			routes: {
				update:  route('user.update'),
				destroy: route('user.destroy')
			}
		})
	}


	/**
	 * Modal methods
	 */

	addAvatar() {
		modalActions.open('uploadMedia', {
			aspect: 'aspect-square',
			endpoint: this.routes.update,
			media: this.getAvatar(),
			method: 'patch',
			reloadPageProps: ['auth.user.image', 'auth.user.media'],
			type: 'avatar',
		})
	}

	delete() {
		modalActions.open('deleteUser', { user: this })
	}


	/**
	 * Media methods
	 */

	getAvatar() {
		return this.media?.filter(m => m.type === 'avatar')?.[0] || null
	}


	/**
	 * HTTP methods
	 */

	_update(data) {
		router.patch(
			this.routes.update,
			data,
			{
				onFinish: (response) => {
					router.visit( router.page.url, { only: ['auth.user'] })
				}
			}
		)
	}
}