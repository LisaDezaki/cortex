import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

export default class UserObject {
	constructor(userData) {
		Object.assign(this, userData, {
			routes: {
				show:   route('users.show',   { user: userData.slug }),
				update: route('users.update', { user: userData.slug })
			}
		})
	}

	test() {
		console.log('test')
	}

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