import { redirect } from '@sveltejs/kit'
import type { LayoutServerLoad } from './$types'

// GET:    Middleware to check for authorization
export const load: LayoutServerLoad = ({ locals, routeId, getClientAddress }) => {
	if (!locals.user) {
		console.log('Unauthorized attempt: %s from %s', routeId, getClientAddress())
		throw redirect(302, '/login')
	}
}
