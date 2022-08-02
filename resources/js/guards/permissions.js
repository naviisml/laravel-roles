import { store } from '../utils/store'

export default (to, from, next, permissions) => {
	// Grab the user
	const user = store.getters['auth/user'] || false

	if (!user)
		return next({ name: '401' })

	// Split roles into an array
	permissions = permissions.split(',')
	
	// Check if the user has one of the required roles...
	for(var i = 0; i < permissions.length; i++) {
		if (!user.permissions[permissions[i]] || user.permissions[permissions[i]] == false) {
			return next({ name: '401' })
		}
	}

	next()
}
